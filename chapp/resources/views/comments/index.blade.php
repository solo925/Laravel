<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Comments</span>
                    <a href="{{ route('comments.create') }}" class="btn btn-primary btn-sm">Add Comment</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @forelse ($comments as $comment)
                        @include('comments._comment', ['comment' => $comment])
                    @empty
                        <p>No comments yet.</p>
                    @endforelse
                    {{ $comments->links('pagination::tailwind') }}

                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
