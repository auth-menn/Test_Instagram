<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
            <i class="fas fa-archive mr-2"></i> Archived Posts
        </h2>
    </x-slot>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="border-t border-gray-300 dark:border-gray-700 mb-6">
            <div class="flex justify-center">
                <a href="{{ route('profile.show') }}" class="group">
                    <button class="px-6 py-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center transition duration-200 ease-in-out transform hover:-translate-y-1">
                        <i class="fas fa-th mr-2 text-lg"></i> Posts
                    </button>
                </a>
                <button class="px-6 py-3 border-t-2 border-blue-500 text-blue-500 flex items-center font-medium transition duration-200 ease-in-out">
                    <i class="fas fa-bookmark mr-2 text-lg"></i> Archive
                </button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium mb-4 text-gray-700 dark:text-gray-300 flex items-center">
                <i class="fas fa-file-export mr-2"></i> Export Archives
            </h3>
            
            <form action="{{ route('archives.export') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <div class="flex items-center">
                    <div class="relative">
                        <i class="fas fa-calendar text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                        <input type="date" name="start_date" class="border rounded-lg pl-10 pr-3 py-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ request('start_date') }}">
                    </div>
                    
                    <span class="mx-2 text-gray-500 dark:text-gray-400">to</span>
                    
                    <div class="relative">
                        <i class="fas fa-calendar text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                        <input type="date" name="end_date" class="border rounded-lg pl-10 pr-3 py-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ request('end_date') }}">
                    </div>
                </div>
                
                <div class="relative">
                    <i class="fas fa-file-alt text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"></i>
                    <select name="format" class="border rounded-lg pl-10 pr-8 py-2 appearance-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="pdf">PDF</option>
                        <option value="xlsx">Excel</option>
                    </select>
                    <i class="fas fa-chevron-down text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"></i>
                </div>
            
                <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition duration-200 flex items-center">
                    <i class="fas fa-download mr-2"></i> Download
                </button>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4 text-gray-700 dark:text-gray-300 flex items-center">
                <i class="fas fa-list-alt mr-2"></i> Archived Posts
            </h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-3 rounded-tl-lg"><i class="fas fa-photo-video mr-2"></i>Media</th>
                            <th class="px-4 py-3"><i class="far fa-calendar-alt mr-2"></i>Post Date</th>
                            <th class="px-4 py-3"><i class="fas fa-comment-alt mr-2"></i>Caption</th>
                            <th class="px-4 py-3 rounded-tr-lg"><i class="fas fa-cog mr-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($archives as $post)
                            <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 transition duration-150">
                                <td class="px-4 py-3">
                                    @php
                                        $mediaPath = public_path('storage/' . $post->media);
                                    @endphp

                                    <div class="relative group">
                                        @if($post->media && file_exists($mediaPath))
                                            @if($post->file_type == 'image')
                                                <img src="{{ asset('storage/' . $post->media) }}" class="h-20 w-20 object-cover rounded-lg shadow-sm hover:shadow-md transition-all" />
                                                <div class="absolute bottom-0 right-0 bg-black bg-opacity-60 text-white rounded-bl-lg rounded-tr-lg p-1">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @elseif($post->file_type == 'video')
                                                <div class="relative h-20 w-20">
                                                    <video class="h-full w-full object-cover rounded-lg shadow-sm hover:shadow-md transition-all" controls>
                                                        <source src="{{ asset('storage/' . $post->media) }}" type="video/mp4">
                                                    </video>
                                                    <div class="absolute bottom-0 right-0 bg-black bg-opacity-60 text-white rounded-bl-lg rounded-tr-lg p-1">
                                                        <i class="fas fa-video"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="h-20 w-20 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg">
                                                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                                                <span class="text-red-500 text-xs mt-1 block">Media missing</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $post->created_at->format('d M Y') }}</span>
                                        <span class="text-xs text-gray-500">{{ $post->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="max-w-xs truncate">
                                        {{ $post->caption }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <form action="{{ route('archives.restore', $post->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 flex items-center">
                                                <i class="fas fa-undo-alt mr-1"></i> Restore
                                            </button>
                                        </form>

                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to permanently delete this post?')" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200 flex items-center">
                                                <i class="fas fa-trash-alt mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-folder-open text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                                        <p>No archived posts found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($archives) && method_exists($archives, 'links'))
                <div class="mt-4">
                    {{ $archives->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
