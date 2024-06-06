@extends('layouts.master')

@section('title')
    Edit {{ $category['name'] }}
@endsection

@section('content')
    <form action="{{ url("admin/categories/{$category['id']}/update") }}" enctype="multipart/form-data" method="POST">
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name"
                value="{{ $category['name'] }}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
