<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ServiceBody;

class ServiceBodyController extends Controller
{
    public function index()
    {
        $serviceBodies = ServiceBody::all();
        $response = Http::get('https://latest.aws.bmlt.app/main_server/client_interface/json/?switcher=GetServiceBodies');
        $availableServiceBodies = $response->json();

        return view('service-bodies.index', compact('serviceBodies', 'availableServiceBodies'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'keyword' => 'required|string|max:255',
        ]);

        ServiceBody::updateOrCreate(
            ['id' => $request->input('id')],
            ['keyword' => $request->input('keyword')]
        );

        return redirect()->route('service-bodies.index')->with('success', 'Service body keyword updated successfully.');
    }
}
