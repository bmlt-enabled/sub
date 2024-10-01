<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Services\RootServerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FeedController extends Controller
{
    protected RootServerService $rootServerService;

    public function __construct(RootServerService $rootServerService)
    {
        $this->rootServerService = $rootServerService;
    }

    public function index()
    {
        $feeds = Feed::all();
        return view('feeds.index', compact('feeds'));
    }

    public function create()
    {
        $availableServiceBodies = $this->availableServiceBodies();
        return view('feeds.create', compact('availableServiceBodies'));
    }

    public function edit($id)
    {
        $availableServiceBodies = $this->availableServiceBodies();
        $feed = Feed::findOrFail($id);
        return view('feeds.edit', compact('feed', 'availableServiceBodies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_body_id' => 'required|int',
            'name' => 'required|string|max:255|unique:feeds,name,' . $id,
            'subscribe_keyword' => 'required|string|max:255|unique:feeds,subscribe_keyword,' . $id . '|different:unsubscribe_keyword',
            'unsubscribe_keyword' => 'required|string|max:255|unique:feeds,unsubscribe_keyword,' . $id . '|different:subscribe_keyword',
        ]);

        $feed = Feed::findOrFail($id);
        $feed->update($request->all());

        return redirect()->route('feeds.index')->with('success', 'Feed updated successfully.');
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

    public function availableServiceBodies() : array {
        $availableServiceBodies = auth()->user()->serviceBodies->toArray();
        $serviceBodies = $this->rootServerService->getServiceBodies();

        foreach ($availableServiceBodies as &$availableServiceBody) {
            $serviceBodyId = $availableServiceBody['service_body_id'];
            $serviceBodyKey = array_search($serviceBodyId, array_column($serviceBodies, 'id'));
            if ($serviceBodyKey !== false) {
                $availableServiceBody['name'] = $serviceBodies[$serviceBodyKey]['name'];
            }
        }

        return $availableServiceBodies;
    }
}
