<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FeedController extends Controller
{
    public function index()
    {
        $feeds = Feed::all();
        return view('feeds.index', compact('feeds'));
    }

    public function create()
    {
        $response = Http::get('https://latest.aws.bmlt.app/main_server/client_interface/json/?switcher=GetServiceBodies');
        $availableServiceBodies = $response->json();
        return view('feeds.create', ['availableServiceBodies' => $availableServiceBodies]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_body_id' => 'required|int',
            'name' => 'required|string|max:255',
            'subscribe_keyword' => 'required|string|max:255',
            'unsubscribe_keyword' => 'required|string|max:255',
        ]);

        Feed::create($request->all());

        return redirect()->route('feeds.index')->with('success', 'Feed created successfully.');
    }
}
