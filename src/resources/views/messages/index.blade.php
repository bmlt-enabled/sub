@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Messages</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('messages.send') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="content">Message Content:</label>
                <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="service_body_id">Select Service Body:</label>
                <select name="service_body_id" id="service_body_id" class="form-control" required>
                    @foreach($serviceBodies as $serviceBody)
                        <option value="{{ $serviceBody->id }}">{{ $serviceBody->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Send Message</button>
        </form>

        <hr>

        <h2>Message Log</h2>
        <ul class="list-group">
            @foreach ($messages as $message)
                <li class="list-group-item">
                    {{ $message->content }} - Sent by {{ $message->user->name }} at {{ $message->created_at }}
                </li>
            @endforeach
        </ul>
    </div>
@endsection
