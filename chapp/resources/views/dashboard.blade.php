<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Feed') }}
            </h2>
            <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                + Create Post
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- LinkedIn-style Feed -->
            <div class="space-y-6">
                @forelse($posts as $post)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <!-- Post Header -->
                        <div class="p-6 pb-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $post->user->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $post->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        @if($post->user_id === auth()->id())
                                            <div class="flex space-x-2">
                                                <a href="{{ route('posts.edit', $post) }}" class="text-gray-400 hover:text-blue-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-gray-400 hover:text-red-600">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="px-6 pb-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                {{ $post->title }}
                            </h2>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $post->description }}
                            </p>
                            
                            @if($post->image_url)
                                <div class="mt-4">
                                    <img src="{{ $post->image_url }}" alt="Post image" class="rounded-lg w-full max-h-96 object-cover">
                                </div>
                            @endif
                        </div>

                        <!-- Post Actions -->
                        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-6">
                                    <form action="{{ route('likes.toggle') }}" method="POST" class="like-form inline">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <button type="submit" class="flex items-center space-x-2 transition-colors like-btn
                                            @if($post->isLikedBy(auth()->id()))
                                                text-red-500 hover:text-red-600
                                            @else
                                                text-gray-500 hover:text-red-500
                                            @endif">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <span class="like-text">
                                                @if($post->isLikedBy(auth()->id()))
                                                    Unlike
                                                @else
                                                    Like
                                                @endif
                                            </span>
                                            <span class="like-count">({{ $post->like_count }})</span>
                                        </button>
                                    </form>
                                    <button class="flex items-center space-x-2 text-gray-500 hover:text-green-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <span>{{ $post->comments->count() }} Comments</span>
                                    </button>
                                    <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                        </svg>
                                        <span>Share</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        @if($post->comments->count() > 0)
                            <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                <div class="space-y-3">
                                    @foreach($post->comments->take(3) as $comment)
                                        <div class="flex space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ substr($comment->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                                                    <div class="flex items-center space-x-2 mb-1">
                                                        <span class="font-semibold text-sm text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->body }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    @if($post->comments->count() > 3)
                                        <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View all {{ $post->comments->count() }} comments
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Add Comment Form -->
                        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('comments.store') }}" class="flex space-x-3">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="body" placeholder="Add a comment..." 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                           required>
                                </div>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    Post
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-8 text-center">
                        <div class="text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            <h3 class="text-lg font-medium mb-2">No posts yet</h3>
                            <p class="mb-4">Be the first to share something with your network!</p>
                            <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                Create your first post
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript for Like Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.like-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const button = this.querySelector('.like-btn');
                    const likeText = this.querySelector('.like-text');
                    const likeCount = this.querySelector('.like-count');
                    
                    // Disable button during request
                    button.disabled = true;
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update button appearance
                        if (data.liked) {
                            button.className = button.className.replace('text-gray-500 hover:text-red-500', 'text-red-500 hover:text-red-600');
                            likeText.textContent = 'Unlike';
                        } else {
                            button.className = button.className.replace('text-red-500 hover:text-red-600', 'text-gray-500 hover:text-red-500');
                            likeText.textContent = 'Like';
                        }
                        
                        // Update like count
                        likeCount.textContent = `(${data.like_count})`;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong. Please try again.');
                    })
                    .finally(() => {
                        // Re-enable button
                        button.disabled = false;
                    });
                });
            });
        });
    </script>
</x-app-layout>