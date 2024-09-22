@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Feeds</h1>
        <a href="{{ route('feeds.create') }}" class="btn btn-primary">Create New Feed</a>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Service Body</th>
                    <th>Name</th>
                    <th>Subscribe Keyword</th>
                    <th>Unsubscribe Keyword</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feeds as $feed)
                    <tr>
                        <td>{{ $feed->service_body_id }}</td>
                        <td>{{ $feed->name }}</td>
                        <td>{{ $feed->subscribe_keyword }}</td>
                        <td>{{ $feed->unsubscribe_keyword }}</td>
                        <td>
                            <a href="{{ route('feeds.subscribers.index', $feed->id) }}" class="btn btn-info">Subscribers</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
