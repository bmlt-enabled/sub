<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RootServerService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $rootServerService;

    public function __construct(RootServerService $rootServerService)
    {
        $this->rootServerService = $rootServerService;
    }

    // Display a list of users
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        $serviceBodies = $this->rootServerService->getServiceBodies();
        return view('users.create', compact('serviceBodies'));
    }

    // Store a newly created user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'service_bodies' => 'array'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        if (isset($validated['service_bodies'])) {
            foreach ($validated['service_bodies'] as $serviceBodyId) {
                $user->serviceBodies()->create([
                    'service_body_id' => $serviceBodyId
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        $serviceBodies = $this->rootServerService->getServiceBodies();
        $userServiceBodies = $user->serviceBodies ? $user->serviceBodies->pluck('service_body_id')->toArray() : [];
        return view('users.edit', compact('user', 'serviceBodies', 'userServiceBodies'));
    }

    // Update the specified user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'service_bodies' => 'array'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);

        $user->serviceBodies()->delete(); // Remove existing relationships

        if (isset($validated['service_bodies'])) {
            foreach ($validated['service_bodies'] as $serviceBodyId) {
                $user->serviceBodies()->create([
                    'service_body_id' => $serviceBodyId
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        // Check if the user trying to delete is the authenticated user
        if (auth()->user()->id == $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        // If it's not the logged-in user, proceed with deletion
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

}
