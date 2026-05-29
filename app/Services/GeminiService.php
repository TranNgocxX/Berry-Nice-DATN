<!-- 
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Repositories\ServiceRepository;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl;
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->apiKey = config('services.gemini.key');
        $this->apiUrl = config('services.gemini.url');

        $this->serviceRepository = $serviceRepository;
    }

    public function askAI(string $userMessage): string
    {
        if (empty($this->apiKey)) {
            Log::error('Gemini API Error: Khuyết GEMINI_API_KEY trong file .env');
            return 'Hệ thống AI chưa được cấu hình mã xác thực. Vui lòng kiểm tra lại file .env!';
        }

        try {
            // 1. Tìm kiếm dịch vụ liên quan từ Repository
            $matchedServices = $this->serviceRepository->findRelevant($userMessage);

            // 2. Nếu trống, trả về chuỗi điều hướng luôn không gọi API nữa
            if ($matchedServices->isEmpty()) {
                return "BerryNice hiện có các dịch vụ Chăm sóc da mặt, Massage body, Gội đầu dưỡng sinh. Bạn có thể mô tả rõ hơn tình trạng da hoặc nhu cầu để mình tư vấn chính xác nhé! 🥰";
            }

            // 3. Xây dựng ngữ cảnh Prompt sạch
            $context = $this->buildSystemContext($matchedServices);

            // 4. Gửi Request với cấu trúc payload chuẩn chỉnh 100% của Google
            $response = Http::timeout(20)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->apiUrl}?key={$this->apiKey}", [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                [
                                    'text' => $context . "\n\n[Yêu cầu từ khách hàng]: \"" . $userMessage . "\"\n[Phản hồi tư vấn]:"
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.6,
                        'maxOutputTokens' => 350,
                    ]
                ]);

            // Nếu gặp lỗi, ta ghi đè body lỗi ra log để dễ dàng kiểm tra trực tiếp
            if (!$response->successful()) {

                Log::error('Gemini API Phản hồi thất bại', [
                    'status' => $response->status(),
                    'error_detail' => $response->body()
                ]);

                // FALLBACK LOCAL RESPONSE
                $topService = $matchedServices->first();

                return "BerryNice gợi ý liệu trình '{$topService->name}' 🌸 "
                    . ($topService->short_description ?? '')
                    . " Giá hiện tại khoảng "
                    . number_format($topService->price)
                    . " VNĐ. "
                    . "Bạn có thể bấm 'Đặt lịch ngay' để được giữ chỗ nhanh nhé!";
            }

            $result = $response->json();

            return $result['candidates'][0]['content']['parts'][0]['text']
                ?? 'BerryNice đã ghi nhận nhu cầu của bạn, bạn có muốn đặt lịch hẹn ngay không ạ?';
        } catch (\Exception $e) {
            Log::error('Gemini Service sập do ngoại lệ Exception', [
                'message' => $e->getMessage()
            ]);
            return 'Kết nối mạng tới máy chủ AI bị gián đoạn. Bạn vui lòng thử lại nhé.';
        }
    }

    private function buildSystemContext($services): string
    {
        $context = "Bạn là trợ lý ảo AI thông minh, tư vấn viên sắc đẹp tại Spa BerryNice.\n";
        $context .= "Dưới đây là danh sách các dịch vụ THỰC TẾ tại Spa phù hợp nhất với nhu cầu của khách:\n\n";

        foreach ($services as $service) {
            $context .= "- Tên dịch vụ: " . $service->name . "\n";
            // Đảm bảo bọc kiểm tra tránh trường hợp thuộc tính trả về null hoặc trống
            $context .= "  Mô tả: " . ($service->short_description ?? 'Đang cập nhật') . "\n";
            $context .= "  Giá: " . number_format($service->price) . " VNĐ\n\n";
        }

        $context .= "HƯỚNG DẪN TRẢ LỜI CHO BẠN:\n";
        $context .= "1. Hãy phân tích từ câu hỏi của khách, nêu rõ lý do vì sao dịch vụ trong danh sách trên lại giải quyết được vấn đề của họ.\n";
        $context .= "2. Giọng văn ngọt ngào, dùng tiếng Việt, ngắn gọn tầm 100 từ.\n";
        $context .= "3. Định hướng khách bấm nút 'Đặt lịch ngay' trên thanh hệ thống để trải nghiệm.";

        return $context;
    }
} -->
