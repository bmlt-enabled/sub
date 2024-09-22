@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Feed: {{ $feed->name }}</h1>
        <table class="table mt-4">
            <thead>
            <tr>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($subscribers as $subscriber)
                <tr>
                    <td>{{ $subscriber->phone_number }}</td>
                    <td>
                        <form action="{{ route('feeds.subscribers.destroy', [$feed->id, $subscriber->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
