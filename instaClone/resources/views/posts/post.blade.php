@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Post</h2>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Body</label>
            <textarea name="body" class="form-control" rows="5" required>{{ old('body') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Publish</button>
    </form>
</div>
@endsection
