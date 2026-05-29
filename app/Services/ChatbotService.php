<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    // Tư vấn DV dựa trên message người dùng gửi lên
    public function consultServices(string $message): array
    {
        // 1. Dùng AI Gemini để phân tích xem KH đang muốn gì (Intent Detection)
        $detectedCategory = $this->detectCategoryWithAI($message);

        // 2. Lấy ds DV phù hợp từ DB dựa trên kết quả phân tích của AI
        $services = $this->findMatchingServices($detectedCategory, $message);

        // 3. Nhờ AI viết một câu trả lời tự nhiên, cá nhân hóa dựa trên dịch vụ tìm được
        $reply = $this->generateAiReply($message, $services, $detectedCategory);

        return [
            'success'  => true,
            'reply'    => $reply,
            'services' => $services->values(),
        ];
    }

    // Sử dụng Gemini để phân tích message và trả về category phù hợp
    private function detectCategoryWithAI(string $message): string
    {
        $categories = array_keys(config('chatbot.categories')); // ['skin_care', 'massage', 'waxing',...]

        $prompt = "Bạn là trợ lý AI của Spa BerryNice. Hãy phân tích tin nhắn của khách hàng: \"{$message}\" " .
            "và xếp nó vào một trong các nhóm sau: [" . implode(', ', $categories) . "]. " .
            "Nếu không thuộc nhóm nào, hãy trả về 'unknown'. Chỉ trả ra duy nhất từ khóa của nhóm, không giải thích gì thêm.";

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post(config('services.gemini.url') . '?key=' . config('services.gemini.key'), [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ]);

            if ($response->successful()) {
                // $result = trim($response->json('candidates.0.content.parts.0.text'));
                $result = strtolower(
                    trim(
                        preg_replace(
                            '/[^a-z_]/',
                            '',
                            $response->json('candidates.0.content.parts.0.text')
                        )
                    )
                );
                return in_array($result, $categories) ? $result : 'unknown';
            }
        } catch (\Exception $e) {
            Log::error('Gemini Detect Category Error: ' . $e->getMessage());
        }

        return 'unknown';
    }

    // Tìm dịch vụ phù hợp dựa trên category đã được AI phân tích
    private function findMatchingServices(string $categoryKey, string $message): Collection {

        $query = Service::query();

        // Filter category
        if ($categoryKey !== 'unknown' && config("chatbot.categories.$categoryKey")) {

            $categoryId = config("chatbot.categories.$categoryKey.id");

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }
        }

        $message = mb_strtolower($message); 
        $message = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $message); 

        // Tách message thành các từ khóa, loại bỏ stop words và từ ngắn để tăng độ chính xác khi so khớp với tên và mô tả dịch vụ
        $words = collect(explode(' ', $message))
            ->map(fn($w) => trim($w))
            ->filter(function ($word) {

                // bỏ từ quá ngắn
                if (mb_strlen($word) < 3) {
                    return false;
                }

                // stop words
                $stopWords = [
                    'bên', 'mình', 'có', 'nào', 'không', 'shop', 'spa', 'phương', 'pháp', 'giúp', 'cho', 'với', 'hay', 'ạ', 'ơi'
                ];

                return !in_array($word, $stopWords);
            })
            ->values();

        $services = $query->get()->map(function ($service) use ($words) {

            $score = 0;
            $name = mb_strtolower($service->name ?? '');
            $short = mb_strtolower($service->short_description ?? '');

            foreach ($words as $word) {
                // match tên
                if (str_contains($name, $word)) {
                    $score += 10;
                }
                // match mô tả
                if (str_contains($short, $word)) {
                    $score += 5;
                }
            }

            $service->match_score = $score;

            return $service;
        });

        // lọc service có điểm
        $services = $services
            ->filter(fn($s) => $s->match_score > 0)
            ->sortByDesc('match_score')
            ->take(3)
            ->values();

        // fallback
        if ($services->isEmpty() && $categoryKey !== 'unknown') {

            $categoryId = config("chatbot.categories.$categoryKey.id");

            return Service::where('category_id', $categoryId)
                ->limit(3)
                ->get();
        }

        return $services;
    }

    // Tạo câu trả lời dựa trên DV tìm được và category đã match, sử dụng AI để viết câu trả lời 
    private function generateAiReply(string $userMessage, Collection $services, string $categoryKey): string
    {
        if ($services->isEmpty()) {
            return 'BerryNice chưa tìm thấy liệu trình phù hợp hoàn toàn. Bạn có thể mô tả rõ hơn tình trạng da hoặc nhu cầu nhé 🥰';
        }

        $serviceNames = $services->pluck('name')->implode(', ');

        // Lấy câu thoại mẫu làm định hướng cho AI 
        $templateReply = config("chatbot.categories.{$categoryKey}.reply", 'BerryNice có các dịch vụ phù hợp với bạn.');

        $prompt = "Khách hàng nói: \"{$userMessage}\". " .
            "Chúng ta có các dịch vụ phù hợp là: {$serviceNames}. " .
            "Hãy đóng vai trợ lý Spa BerryNice, viết một câu phản hồi thân thiện, ngắn gọn (dưới 3 câu), " .
            "mời chào khách trải nghiệm các dịch vụ trên. Dựa vào văn phong mẫu này: \"{$templateReply}\". " .
            "Hãy thêm các icon dễ thương.";

        try {
            $response = Http::post(config('services.gemini.url') . '?key=' . config('services.gemini.key'), [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]);

            if ($response->successful()) {
                return trim($response->json('candidates.0.content.parts.0.text'));
            }
        } catch (\Exception $e) {
            Log::error('Gemini Generate Reply Error: ' . $e->getMessage());
        }

        // Fallback: Nếu AI lỗi thì dùng cấu hình tĩnh cũ 
        return str_replace(':services', $serviceNames, $templateReply);
    }
}
