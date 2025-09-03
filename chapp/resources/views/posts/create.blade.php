<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Post') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <!-- Post Creation Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ auth()->user()->name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Share an article, photo, video or idea
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Post Creation Form -->
                <form method="POST" action="{{ route('posts.store') }}" class="p-6">
                    @csrf

                    <div class="space-y-6">
                        <!-- Title Field -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                What's on your mind? *
                            </label>
                            <input type="text" 
                                   id="title"
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Give your post a title..."
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                   required>
                            @error('title') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tell us more about it *
                            </label>
                            <textarea id="description"
                                      name="description" 
                                      rows="6"
                                      placeholder="Share your thoughts, ideas, or experiences..."
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-none"
                                      required>{{ old('description') }}</textarea>
                            @error('description') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        <!-- Image URL Field -->
                        <div>
                            <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Add an image (optional)
                            </label>
                            <div class="relative">
                                <input type="url" 
                                       id="image_url"
                                       name="image_url" 
                                       value="{{ old('image_url') }}"
                                       placeholder="https://example.com/image.jpg"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('image_url') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        <!-- Preview Section -->
                        @if(old('image_url'))
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image Preview:</h4>
                                <img src="{{ old('image_url') }}" alt="Preview" class="max-w-full h-48 object-cover rounded-lg" onerror="this.style.display='none'">
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('dashboard') }}" 
                           class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add some JavaScript for image preview -->
    <script>
        document.getElementById('image_url').addEventListener('input', function() {
            const url = this.value;
            const previewContainer = document.querySelector('.border.border-gray-200.dark\\:border-gray-600.rounded-lg.p-4');
            
            if (url && previewContainer) {
                const img = previewContainer.querySelector('img');
                if (img) {
                    img.src = url;
                    img.style.display = 'block';
                }
            }
        });
    </script>
</x-app-layout>