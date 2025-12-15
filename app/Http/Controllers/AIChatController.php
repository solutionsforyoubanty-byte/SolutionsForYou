<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIChatController extends Controller
{
    public function chat(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $apiKey = env('OPENAI_API_KEY');

        // Check if API key exists
        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'AI service is not configured. Please add OPENAI_API_KEY to your .env file.'
            ]);
        }

        try {
            // Call OpenAI API
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini', // Using latest model
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a helpful AI assistant for SolutionsForYou, a web development and digital services company. Help users with questions about web development, digital marketing, app development, and general tech queries. Be friendly, concise, and professional.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $validated['message']
                        ]
                    ],
                    'max_tokens' => 500,
                    'temperature' => 0.7,
                ]);

            // Check if request was successful
            if ($response->successful()) {
                $data = $response->json();
                
                // Extract AI message
                $aiMessage = $data['choices'][0]['message']['content'] ?? 'Sorry, I could not process your request.';
                
                // Log success for debugging
                Log::info('OpenAI API Success', [
                    'user_message' => $validated['message'],
                    'ai_response' => $aiMessage,
                    'tokens_used' => $data['usage']['total_tokens'] ?? 0
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => trim($aiMessage)
                ]);
            }

            // Handle API errors
            $errorData = $response->json();
            $errorMessage = $errorData['error']['message'] ?? 'Unknown error occurred';
            
            Log::error('OpenAI API Error', [
                'status' => $response->status(),
                'error' => $errorMessage,
                'full_response' => $errorData
            ]);

            // Return user-friendly error messages
            if ($response->status() === 401) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid API key. Please check your OpenAI configuration.'
                ]);
            }

            if ($response->status() === 429) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many requests. Please try again in a moment.'
                ]);
            }

            if ($response->status() === 500) {
                return response()->json([
                    'success' => false,
                    'message' => 'OpenAI service is temporarily unavailable. Please try again later.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'AI service error: ' . $errorMessage
            ]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('OpenAI Connection Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Could not connect to AI service. Please check your internet connection.'
            ]);

        } catch (\Exception $e) {
            Log::error('OpenAI General Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sorry, I am currently unavailable. Please try again later.'
            ]);
        }
    }
}