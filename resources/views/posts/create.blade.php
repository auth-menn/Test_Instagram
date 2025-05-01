<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <x-input-label for="media" :value="__('Upload Media (Image or Video)')" />
                    <x-text-input id="media" type="file" name="media" class="mt-1 block w-full" accept="image/*,video/*" required />
                    <x-input-error :messages="$errors->get('media')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="caption" :value="__('Caption (Optional)')" />
                    <textarea name="caption" id="caption" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring focus:ring-indigo-200">{{ old('caption') }}</textarea>
                    <x-input-error :messages="$errors->get('caption')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>{{ __('Post') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
