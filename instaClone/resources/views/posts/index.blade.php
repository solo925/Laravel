@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Posts</h2>

    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $post->title }}</h5>
                <p>{{ Str::limit($post->body, 100) }}</p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-secondary">Read More</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
