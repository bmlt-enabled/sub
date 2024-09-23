<!-- In `resources/views/feeds/edit.blade.php` -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Feed</h1>
        <form action="{{ route('feeds.update', $feed->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="service_body_id">Service Body</label>
                <input type="hidden" name="service_body_id" value="{{ $feed->service_body_id }}">
                <select disabled class="form-control">
                    @foreach($availableServiceBodies as $serviceBody)
                        <option value="{{ $serviceBody['id'] }}" {{ $feed->service_body_id == $serviceBody['id'] ? 'selected' : '' }}>
                            {{ $serviceBody['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $feed->name }}" required>
            </div>

            <div class="form-group">
                <label for="subscribe_keyword">Subscribe Keyword</label>
                <input type="text" name="subscribe_keyword" id="subscribe_keyword" class="form-control" value="{{ $feed->subscribe_keyword }}" required>
            </div>

            <div class="form-group">
                <label for="unsubscribe_keyword">Unsubscribe Keyword</label>
                <input type="text" name="unsubscribe_keyword" id="unsubscribe_keyword" class="form-control" value="{{ $feed->unsubscribe_keyword }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Feed</button>
        </form>
    </div>
@endsection
