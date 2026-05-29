<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatbotRequest;
use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    public function __construct(
        private ChatbotService $chatbotService
    ) {}

    // Xử lý yêu cầu gửi tin nhắn từ chatbot
    public function sendMessage(ChatbotRequest $request): JsonResponse {

        $result = $this->chatbotService
            ->consultServices(
                $request->validated('message')
            );

        return response()->json($result);
    }
}
