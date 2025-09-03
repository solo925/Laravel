<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Post Details
                </h2>
            </div>
            @if($post->user_id === auth()->id())
                <div class="flex space-x-2">
                    <a href="{{ route('posts.edit', $post) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Edit Post
                    </a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Delete Post
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Post -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 mb-6">
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
                                        {{ $post->created_at->format('M d, Y \a\t g:i A') }} • {{ $post->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Post Content -->
                <div class="px-6 pb-4">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $post->title }}
                    </h1>
                    <div class="prose prose-lg max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! nl2br(e($post->description)) !!}
                    </div>
                    
                    @if($post->image_url)
                        <div class="mt-6">
                            <img src="{{ $post->image_url }}" alt="Post image" class="rounded-lg w-full max-h-96 object-cover shadow-lg">
                        </div>
                    @endif
                </div>

                <!-- Post Actions -->
                <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>Like</span>
                            </button>
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
            </div>

            <!-- Comments Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Comments ({{ $post->comments->count() }})
                    </h3>
                </div>

                <!-- Add Comment Form -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('comments.store') }}" class="flex space-x-3">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <textarea name="body" 
                                      placeholder="Write a comment..." 
                                      rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none"
                                      required></textarea>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                Comment
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Comments List -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($post->comments as $comment)
                        <div class="p-6">
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                        {{ $comment->body }}
                                    </p>
                                    
                                    @if($comment->user_id === auth()->id())
                                        <div class="mt-3 flex space-x-4">
                                            <button class="text-sm text-gray-500 hover:text-blue-600 transition-colors">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')" 
                                                        class="text-sm text-gray-500 hover:text-red-600 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="text-lg font-medium mb-2">No comments yet</p>
                                <p class="text-sm">Be the first to share your thoughts!</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>