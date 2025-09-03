<x-app-layout>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Comment Details
                </div>

                <div class="card-body">
                    {{-- @include('comments._comment', ['comments' => $comments]) --}}

                    <div class="mt-3">
                        <a href="{{ route('comments.edit', $comments) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('comments.destroy', $comments) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this comment?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
