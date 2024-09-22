<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use App\Models\Feed;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function index()
    {
        $messages = Message::all();
        $feeds = Feed::all();
        return view('messages.index', compact('messages', 'feeds'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'feed_id' => 'required|exists:feeds,id',
        ]);

        // Get the feed and subscribers
        $feed = Feed::findOrFail($request->feed_id);
        $subscribers = $feed->subscribers;

        // Send SMS to all subscribers in the feed
        foreach ($subscribers as $subscriber) {
            $this->twilioService->sendSms($subscriber->phone_number, $request->content);
        }

        // Store the message in the database
        Message::create([
            'content' => $request->content,
            'feed_id' => $request->feed_id,
        ]);

        return redirect()->route('messages.index')->with('success', 'Message sent!');
    }
}
