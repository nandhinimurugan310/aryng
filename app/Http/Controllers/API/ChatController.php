<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Lead;
use App\Mail\RoadmapMail;
use Barryvdh\DomPDF\Facade\Pdf;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function handle(Request $request)
{
    try {
        $userMessage = $request->input('message');
        $chat = Session::get('chat', []);
        $chat[] = ['role' => 'user', 'content' => $userMessage];

        $response = \OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo', // or gpt-4 if you have access
            'messages' => $chat,
        ]);

        $aiReply = $response['choices'][0]['message']['content'];
        $chat[] = ['role' => 'assistant', 'content' => $aiReply];
        Session::put('chat', $chat);

        return response()->json(['reply' => $aiReply]);

    } catch (\Exception $e) {
        \Log::error("OpenAI API call failed: " . $e->getMessage());
        return response()->json(['reply' => 'Something went wrong with AI.'], 500);
    }
}


    protected function generateAndSendPdf($chat)
    {
        $markdown = "# AI Roadmap Chat Summary\n\n";
        foreach ($chat as $msg) {
            $markdown .= "**" . ucfirst($msg['role']) . "**: " . $msg['content'] . "\n\n";
        }

        $html = \Illuminate\Support\Str::markdown($markdown);
        $pdf = Pdf::loadHTML($html);

        $filename = 'ai_roadmap_' . time() . '.pdf';
        Storage::put("public/{$filename}", $pdf->output());

        $leadId = Session::get('lead_id');
        $lead = Lead::find($leadId);

        if ($lead) {
            Mail::to($lead->email)->send(new RoadmapMail($filename));
        }
    }
}
