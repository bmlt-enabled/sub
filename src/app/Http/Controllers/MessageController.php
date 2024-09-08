<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use App\Models\Subscriber;
use App\Models\ServiceBody;
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
        $serviceBodies = ServiceBody::all();
        return view('messages.index', compact('messages', 'serviceBodies'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'service_body_id' => 'required',
        ]);

        // Get the service body and subscribers
        $serviceBody = ServiceBody::findOrFail($request->service_body_id);
        $subscribers = $serviceBody->subscribers;

        // Send SMS to all subscribers in the service body
        foreach ($subscribers as $subscriber) {
            $this->twilioService->sendSms($subscriber->phone_number, $request->content);
        }

        // Store the message in the database
        Message::create([
            'content' => $request->content,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('messages.index')->with('success', 'Message sent!');
    }
}
