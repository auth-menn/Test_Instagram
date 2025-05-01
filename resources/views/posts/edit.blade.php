@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Edit Post</h2>
        
        <!-- Form Update Post -->
        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Caption Input -->
            <div class="mb-6">
                <label for="caption" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Caption</label>
                <textarea id="caption" name="caption" rows="4" class="mt-1 block w-full px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-gray-300">{{ old('caption', $post->caption) }}</textarea>
                @error('caption')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Media Upload (Optional) -->
            <div class="mb-6">
                <label for="media" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Update Media</label>
                <input type="file" id="media" name="media" accept="image/*,video/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-300">
                @error('media')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Update Post
                </button>
            </div>
        </form>
    </div>
@endsection
