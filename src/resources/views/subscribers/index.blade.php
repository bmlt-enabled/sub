@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table mt-4">
            <thead>
            <tr>
                <th>ID</th>
                <th>Phone Number</th>
                <td>Feed ID</td>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($subscribers as $subscriber)
                <tr>
                    <td>{{ $subscriber->id }}</td>
                    <td>{{ $subscriber->phone_number }}</td>
                    <td>{{ $subscribers->feed }}</td>
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
