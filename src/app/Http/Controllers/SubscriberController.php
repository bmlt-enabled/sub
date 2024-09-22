<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Twilio\TwiML\MessagingResponse;

class SubscriberController extends Controller
{
    public function index()
    {
        $feed_id = request('feed');
        $feed = Feed::find($feed_id);
        $subscribers = Subscriber::where('feed_id', $feed_id)
            ->get();
        return view('subscribers.index', ["feed"=>$feed], compact('subscribers'));
    }

    public function destroy()
    {
        $feed_id = request('feed');
        Subscriber::where('feed_id', $feed_id)
            ->delete();
        return redirect()->route('feeds.subscribers.index', ['feed' => $feed_id]);
    }

    public function subscribe(Request $request)
    {
        // Get phone number and message body
        $phoneNumber = $request->input('From');
        $messageBody = strtolower(trim($request->input('Body')));
        // $serviceBody = $request->get("service_body_id");

        $feed = Feed::where('subscribe_keyword', $messageBody)
            ->orWhere('subscribe_keyword') // Include default if no keyword matches
            ->first();

        $response = new MessagingResponse();

        if ($feed) {
            $existingSubscriber = Subscriber::where('phone_number', $phoneNumber)
                ->where('feed_id', $feed->id)
                ->first();

            if ($existingSubscriber) {
                $response->message('You are already subscribed to ' . $feed->name);
            } else {
                Subscriber::create(
                    ['phone_number' => $phoneNumber,
                    'feed_id' => $feed->id]
                );

                $response->message('You have been subscribed to ' . $feed->name);
            }
        } else {
            $response->message('Invalid keyword');
        }

        return response($response, 200)->header('Content-Type', 'text/xml');
    }
}
