@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Feed</h1>
        <form action="{{ route('feeds.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="service_body_id">Select Service Body</label>
                <select name="service_body_id" id="service_body_id" class="form-control" required>
                    @foreach ($availableServiceBodies as $serviceBody)
                        <option value="{{ $serviceBody['service_body_id'] }}">
                            {{ $serviceBody['name'] }} ({{ $serviceBody['service_body_id'] }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="subscribe_keyword" class="form-label">Subscribe Keyword</label>
                <input type="text" class="form-control" id="subscribe_keyword" name="subscribe_keyword" required>
            </div>
            <div class="mb-3">
                <label for="unsubscribe_keyword" class="form-label">Unsubscribe Keyword</label>
                <input type="text" class="form-control" id="unsubscribe_keyword" name="unsubscribe_keyword" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
