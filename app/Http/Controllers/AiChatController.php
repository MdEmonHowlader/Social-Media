<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\AiChatService;

class AiChatController extends Controller
{
    protected $aiChatService;

    public function __construct(AiChatService $aiChatService)
    {
        $this->aiChatService = $aiChatService;
    }

    /**
     * Handle AI chat messages
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $userMessage = $request->input('message');

        // Use the AI service to generate response
        $aiResponse = $this->aiChatService->generateResponse($userMessage);

        return response()->json([
            'success' => true,
            'message' => $aiResponse,
            'timestamp' => now()->toISOString()
        ]);
    }

    

    /**
     * Get chat history (if you want to implement chat persistence)
     */
    public function history(): JsonResponse
    {
        // This could return chat history from database
        return response()->json([
            'success' => true,
            'messages' => []
        ]);
    }
}
