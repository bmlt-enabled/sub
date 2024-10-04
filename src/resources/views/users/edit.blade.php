<!-- resources/views/users/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit User</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
            </div>

            <div class="form-group">
                <label for="password">Password (Leave blank to keep current password):</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="form-group">
                <label for="rights">Rights:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="rights[]" id="manage_users" value="manage_users" {{ in_array("manage_users", $user->rights) ? 'checked' : '' }}>
                    <label class="form-check-label" for="manage_users">
                        Manage Users
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="rights[]" id="edit_feeds" value="edit_feeds" {{ in_array("edit_feeds", $user->rights) ? 'checked' : '' }}>
                    <label class="form-check-label" for="edit_feeds">
                        Edit Feeds
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="service_bodies">Service Bodies:</label>
                <select multiple class="form-control" id="service_bodies" name="service_bodies[]">
                    @foreach($serviceBodies as $serviceBody)
                        <option value="{{ $serviceBody['id'] }}" {{ in_array($serviceBody['id'], $userServiceBodies) ? 'selected' : '' }}>
                            {{ $serviceBody['name'] }} ({{ $serviceBody['id'] }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
