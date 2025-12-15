<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

Route::post('/ai-chat', function (Request $request) {
    $userMessage = $request->message;

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/responses', [
            'model' => 'gpt-4o-mini',
            'input' => $userMessage
        ]);

        $json = $response->json();

        if (isset($json['output'][0]['content'][0]['text'])) {
            $reply = $json['output'][0]['content'][0]['text'];
        } elseif (isset($json['text'][0])) {
            $reply = $json['text'][0];
        } else {
            $reply = "AI did not return a response.";
        }

        // Save chat history
        DB::table('ai_chat_history')->insert([
            'user_message' => $userMessage,
            'ai_reply' => $reply
        ]);

        return response()->json(['reply' => $reply]);

    } catch (\Exception $e) {
        return response()->json(['reply' => "Error connecting to AI: " . $e->getMessage()]);
    }
});
