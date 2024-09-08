@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Service Bodies</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Keyword</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($serviceBodies as $serviceBody)
                <tr>
                    <td>{{ $serviceBody->id }}</td>
                    <td>{{ $serviceBody->keyword ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('service-bodies.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $serviceBody->id }}">
                            <input type="text" name="keyword" value="{{ $serviceBody->keyword ?? '' }}" required>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h2>Add New Service Body</h2>
        <form action="{{ route('service-bodies.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="serviceBody">Select Service Body</label>
                <select name="id" id="serviceBody" class="form-control" required>
                    @foreach ($availableServiceBodies as $availableServiceBody)
                        <option value="{{ $availableServiceBody['id'] }}">{{ $availableServiceBody['name'] }} ({{ $availableServiceBody['id'] }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="keyword">Keyword</label>
                <input type="text" name="keyword" id="keyword" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Service Body</button>
        </form>
    </div>
@endsection
