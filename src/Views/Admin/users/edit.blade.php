@extends('layouts.master')

@section('title')
    Edit người dùng {{ $user['name'] }}
@endsection

@section('content')

    @if (!empty($_SESSION['errors']))
        <div class="alert alert-warning">
            <ul>
                @foreach ($_SESSION['errors'] as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            @php
                unset($_SESSION['errors']);
            @endphp
        </div>
    @endif

    <form action="{{ url("admin/users/{$user['id']}/update") }}" enctype="multipart/form-data" method="POST">
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name"
                value="{{ $user['name'] }}">
        </div>
        <div class="mb-3 mt-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"
                value="{{ $user['email'] }}">
        </div>
        <div class="mb-3 mt-3">
            <label for="avatar" class="form-label">Avatar:</label>
            <input type="file" class="form-control" id="avatar" placeholder="Enter avatar" name="avatar">
            <img src="{{ asset($user['avatar']) }}" alt="" width="100px">
        </div>
        <div class="form-check">
            <input type="radio" class="form-check-input" id="radio1" name="type" value="admin" 
            {{ $user['type'] == 'admin' ? 'checked' : '' }} >
            <label class="form-check-label" for="radio1">Admin</label>
        </div>
        <div class="form-check">
            <input type="radio" class="form-check-input" id="radio2"  name="type" value="member"
            {{ $user['type'] == 'member' ? 'checked' : '' }}>
            <label class="form-check-label" for="radio2">Member</label>
        </div>

        <div class="mb-3 mt-3">
            <label for="password" class="form-label">Password:</label>
            <input type="text" class="form-control" id="password" placeholder="Enter password" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


@endsection
