@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ $post->title }}</h4>
                    <div>
                        @if(auth()->check() && auth()->id() === $post->user_id)
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">
                            By {{ $post->user->name }} • {{ $post->created_at->format('M d, Y') }}
                        </small>
                    </div>

                    <div class="post-content">
                        {!! nl2br(e($post->body)) !!}
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">← Back to Posts</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
