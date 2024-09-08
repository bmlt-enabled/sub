<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Models\ServiceBody;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::all();
        return view('subscribers.index', compact('subscribers'));
    }

    public function subscribe(Request $request)
    {
        // Get phone number and message body
        $phoneNumber = $request->input('From');
        $messageBody = strtolower(trim($request->input('Body')));
        $serviceBody = $request->get("service_body_id");

        // Find the service body by the keyword, use default if none matches
        // $defaultKeyword = env('SMS_DEFAULT_KEYWORD');
        $serviceBody = ServiceBody::where('keyword', $messageBody)
            ->orWhere('keyword') // Include default if no keyword matches
            ->first();

        if ($serviceBody) {
            // Attach the subscriber to the service body
            Subscriber::create(
                ['phone_number' => $phoneNumber,  // Check for the phone number
                'service_body_id' => $serviceBody->id]
            );

            return response('You have been subscribed to ' . $serviceBody->name, 200);
        }

        return response('Invalid keyword', 200);
    }
}
