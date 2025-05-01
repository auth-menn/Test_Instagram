<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->username ?? $user->name }}'s Profile
        </h2>
    </x-slot>
    @if (session('status') === 'profile-updated')
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-transition 
        class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded shadow-md"
        role="alert"
    >
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline ml-2">{{ __('Your profile has been updated.') }}</span>
    </div>
@endif

    <div class="py-6 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Profile Info -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="relative">
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default.jpg') }}" 
                    alt="Profile Picture"
                    class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover border-2 border-pink-500">
                    @if(Auth::id() == $user->id)
                    <div class="absolute bottom-0 right-0 bg-blue-500 rounded-full p-2 cursor-pointer">
                        <i class="fas fa-camera text-white text-xs"></i>
                    </div>
                    @endif
                </div>
                
                <div class="flex-grow text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center mb-4 gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $user->username ?? $user->name }}</h3>
                
                        @if(Auth::check() && Auth::id() != $user->id)
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-md text-sm font-medium">Follow</button>
                            <button class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-4 py-1 rounded-md text-sm font-medium">Message</button>
                        
                        @elseif(Auth::check() && Auth::id() == $user->id)
                            <a href="{{ route('profile.edit') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-4 py-1 rounded-md text-sm font-medium">
                                {{ __('Edit Profile') }}
                            </a>
                        @endif
                    </div>
                    
                    <div class="flex justify-center md:justify-start space-x-6 mb-4">
                        <div class="text-center">
                            <span class="font-bold text-gray-800 dark:text-white">
                                {{ $user->posts()->where('is_archived', false)->count() }}
                            </span>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Posts</p>
                        </div>
                        <div class="text-center">
                            <span class="font-bold text-gray-800 dark:text-white">{{ isset($user->followers) ? $user->followers->count() : 0 }}</span>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Followers</p>
                        </div>
                        <div class="text-center">
                            <span class="font-bold text-gray-800 dark:text-white">{{ isset($user->following) ? $user->following->count() : 0 }}</span>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Following</p>
                        </div>
                    </div>
                    
                    
                    <div>
                        <p class="font-medium text-gray-800 dark:text-white mb-1">{{ $user->name }}</p>
                        <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $user->bio ?? 'No bio yet.' }}</p>
                        @if($user->website)
                            <a href="{{ $user->website }}" class="text-blue-500" target="_blank">{{ $user->website }}</a>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>

        @if(isset($user->stories) && $user->stories->count() > 0)
        <div class="mb-6 overflow-x-auto">
            <div class="flex space-x-4 pb-2">
                @if(Auth::id() == $user->id)
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full border-2 border-gray-300 flex items-center justify-center">
                        <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-plus text-gray-500"></i>
                        </div>
                    </div>
                    <span class="text-xs mt-1 text-gray-700 dark:text-gray-300">New</span>
                </div>
                @endif
                
                @if(isset($user->storyHighlights))
                    @foreach($user->storyHighlights as $highlight)
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-full border-2 border-pink-500 p-0.5">
                            <img src="{{ asset($highlight->cover_image ?? 'default-highlight.jpg') }}" class="rounded-full w-full h-full object-cover" alt="Story">
                        </div>
                        <span class="text-xs mt-1 text-gray-700 dark:text-gray-300">{{ $highlight->name }}</span>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endif

<div class="border-t border-gray-300 dark:border-gray-700 mb-4">
    <div class="flex justify-center">
        <button class="flex items-center px-4 py-2 border-t-2 border-blue-500 text-blue-500">
            <i class="fas fa-th mr-1"></i>
            <span>Posts</span>
        </button>

        @if(Auth::id() == $user->id)
            <a href="{{ route('archives.index') }}">
                <button class="flex items-center px-4 py-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-bookmark mr-1"></i>
                    <span>Archive</span>
                </button>
            </a>
        @endif
    </div>
</div>

        @if(Auth::id() == $user->id)
        <div class="flex justify-end mt-6">
            <a href="{{ route('posts.create') }}" class="group inline-flex items-center px-5 py-2.5 rounded-lg bg-gradient-to-r from-blue-500 to-blue-700 text-white font-medium text-sm transition-all duration-300 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>New Post</span>
            </a>
        </div>
    @endif

        <!-- Feed Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-1 sm:gap-4 mt-4">
            @forelse ($user->posts->where('is_archived', false) as $post)
                <div class="aspect-square overflow-hidden rounded-lg post-hover relative" 
                     onclick="openPostModal('{{ $post->id }}', '{{ asset('storage/' . $post->media) }}', '{{ $post->caption ?? '' }}', '{{ $post->created_at->format('F d, Y') }}', {{ isset($post->likes) ? $post->likes->count() : 0 }}, {{ isset($post->comments) ? $post->comments->count() : 0 }}, {{ Auth::check() && $post->likes && $post->likes->contains('user_id', Auth::id()) ? 'true' : 'false' }})">
        
                    @if(Str::endsWith($post->media, ['.mp4', '.mov', '.avi', '.wmv']))
                        <div class="video-indicator absolute top-2 left-2 bg-black bg-opacity-50 text-white px-1.5 py-1 text-xs rounded">
                            <i class="fas fa-play"></i>
                        </div>
        
                        @if($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}"
                                 class="w-full h-full object-cover"
                                 alt="{{ $post->caption ?? '' }}" />
                        @else
                            <video class="w-full h-full object-cover" muted autoplay loop>
                                <source src="{{ asset('storage/' . $post->media) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
        
                    @else
                        <img src="{{ asset('storage/' . $post->media) }}"
                             class="w-full h-full object-cover"
                             alt="{{ $post->caption ?? '' }}" />
                    @endif
        
                    <div class="post-overlay absolute inset-0 bg-black bg-opacity-40 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                        <div class="flex space-x-6">
                            <div class="flex items-center">
                                <i class="fas fa-heart mr-2"></i>
                                <span>{{ isset($post->likes) ? $post->likes->count() : 0 }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-comment mr-2"></i>
                                <span>{{ isset($post->comments) ? $post->comments->count() : 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500 py-10">Belum ada postingan.</p>
            @endforelse
        </div>
        
    </div>

    <div id="postModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center">
        <!-- Back Button -->
        <div class="absolute top-4 left-4 flex items-center gap-2">
            <button onclick="closePostModal()" class="group flex items-center gap-2 bg-gray-800 hover:bg-gray-700 text-white font-medium px-4 py-2 rounded-lg shadow-lg backdrop-blur-sm bg-opacity-60 hover:bg-opacity-80 transition-all duration-200 focus:ring-2 focus:ring-white focus:ring-opacity-50 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Back</span>
            </button>
        </div>
        
        <div class="bg-white dark:bg-gray-900 w-full max-w-4xl rounded-lg overflow-hidden flex flex-col md:flex-row max-h-[90vh]">
            <!-- Media Section -->
            <div class="md:w-7/12 bg-black flex items-center justify-center">
                <img id="modalImage" src="" alt="Post" class="max-h-[90vh] md:max-h-[80vh] w-full md:w-auto object-contain hidden">
                <video id="modalVideo" class="max-h-[90vh] md:max-h-[80vh] w-full md:w-auto object-contain hidden" controls muted autoplay loop>
                    <source id="modalVideoSource" src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        
            <!-- Right Side - Info & Comments -->
            <div class="md:w-5/12 flex flex-col h-full max-h-[90vh] md:max-h-[80vh]">
<div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
    <div class="flex items-center">
        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default.jpg') }}" 
             class="w-8 h-8 rounded-full object-cover mr-2">
        <p class="font-semibold text-gray-800 dark:text-white">{{ $user->username ?? $user->name }}</p>
    </div>

    @if(Auth::check() && Auth::id() == $user->id)
    <div class="relative">
        <button onclick="toggleDropdown()" class="bg-white dark:bg-gray-800 rounded-full p-2 hover:bg-gray-200 dark:hover:bg-gray-700 shadow-sm">
            <i class="fas fa-ellipsis-h text-gray-800 dark:text-white"></i>
        </button>

        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-50">
            
            <form id="archiveForm" method="POST" action="#">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-yellow-600 hover:bg-yellow-50 dark:hover:bg-gray-700 dark:text-yellow-400">
                    Archive
                </button>
            </form>
        
            <form id="deleteForm" method="POST" action="#" onsubmit="return confirm('Yakin ingin menghapus postingan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-gray-700 dark:text-red-400">Hapus</button>
            </form>
        </div>
        
        
    </div>
    @endif
</div>

                <div class="flex-grow overflow-y-auto p-4">
                    <!-- Caption -->
                    <div class="flex mb-4">
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default.jpg') }}" 
                             class="w-8 h-8 rounded-full object-cover mr-2">
                        <div>
                            <p>
                                <span class="font-semibold text-gray-800 dark:text-white">{{ $user->username ?? $user->name }}</span>
                                <span id="modalCaption" class="text-gray-700 dark:text-gray-300"></span>
                            </p>
                            <p id="modalDate" class="text-xs text-gray-500 mt-1"></p>
                        </div>
                    </div>
        
                    <!-- Comments Section -->
                    <div id="commentsSection" class="space-y-3">
                    </div>
                </div>
        
                <!-- Like, Comment, Actions -->
                <div class="border-t border-gray-200 dark:border-gray-700">
                    <div class="p-4">
                        <div class="flex items-center mb-2">
                            <button id="likeButton" onclick="toggleLike()" class="text-2xl mr-4">
                                <i id="likeIcon" class="far fa-heart"></i>
                            </button>
                            <button class="text-2xl mr-4">
                                <i class="far fa-comment"></i>
                            </button>
                            <button class="text-2xl">
                                <i class="far fa-paper-plane"></i>
                            </button>
                        </div>
                        <p class="font-semibold text-sm mb-1"><span id="likesCount">0</span> likes</p>
                        <p id="uploadDate" class="text-xs text-gray-500"></p>
                    </div>
        
                    <!-- Add Comment -->
                    <form id="commentForm" class="border-t border-gray-200 dark:border-gray-700 p-3 flex items-center">
                        <input type="hidden" id="postId" value="">
                        <textarea id="commentText" placeholder="Add a comment..." class="flex-grow py-2 px-3 text-sm bg-transparent focus:outline-none resize-none h-10 overflow-hidden text-gray-700 dark:text-gray-300"></textarea>
                        <button type="submit" class="ml-2 text-blue-500 font-semibold text-sm">Post</button>
                    </form>
                </div>
            </div>
        </div>
    <x-slot name="styles">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <style>

            .video-indicator {
                position: absolute;
                top: 10px;
                right: 10px;
                color: white;
                background-color: rgba(0, 0, 0, 0.5);
                padding: 4px;
                border-radius: 50%;
            }
            
            body.modal-open {
                overflow: hidden;
            }
            
            #commentText {
                min-height: 36px;
                max-height: 80px;
            }
            
            .liked {
                color: #ed4956;
            }
        </style>
    </x-slot>

    <!-- Mobile Bottom Navigation Bar -->
    @auth
    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 md:hidden z-40">
        <div class="flex justify-around py-3">
            <a href="{{ url('/') }}" class="text-gray-700 dark:text-gray-300">
                <i class="fas fa-home text-xl"></i>
            </a>
            <a href="#" class="text-gray-700 dark:text-gray-300">
                <i class="fas fa-search text-xl"></i>
            </a>
            <a href="{{ route('posts.create') }}" class="text-blue-600 dark:text-blue-400">
                <i class="fas fa-plus-square text-xl"></i>
            </a>
            <a href="#" class="text-gray-700 dark:text-gray-300">
                <i class="fas fa-heart text-xl"></i>
            </a>
            <a href="{{ url('/profile/' . (Auth::user()->username ?? Auth::id())) }}" 
               class="{{ request()->is('profile/' . (Auth::user()->username ?? Auth::id())) ? 'text-blue-500' : 'text-gray-700 dark:text-gray-300' }}">
                <i class="fas fa-user text-xl"></i>
            </a>
        </div>
    </div>
    @endauth
    <script>
        const modalImage = document.getElementById('modalImage');
        const modalVideo = document.getElementById('modalVideo');
        const modalVideoSource = document.getElementById('modalVideoSource');
        const modalCaption = document.getElementById('modalCaption');
        const modalDate = document.getElementById('modalDate');
        const uploadDate = document.getElementById('uploadDate');
        const likesCountEl = document.getElementById('likesCount');
        const postIdInput = document.getElementById('postId');
        const likeIcon = document.getElementById('likeIcon');
        const commentsSection = document.getElementById('commentsSection');
        const commentForm = document.getElementById('commentForm');
        const commentTextarea = document.getElementById('commentText');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const editLink = document.getElementById('editLink');
        const archiveForm = document.getElementById('archiveForm');
        const deleteForm = document.getElementById('deleteForm');
        const postModal = document.getElementById('postModal');
    
        let currentPostId = null;
        let isLiked = false;
        let likesCount = 0;
        let isDropdownListenerAdded = false;
    
      
        function apiFetch(url, method = 'GET', body = null) {
            const headers = {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };
            return fetch(url, {
                method,
                headers,
                body: body ? JSON.stringify(body) : null
            });
        }
    
        function openPostModal(postId, mediaUrl, caption, createdAt, likeCount, commentCount, liked) {
            currentPostId = postId;
            likesCount = likeCount;
            isLiked = liked === true;
    
            modalImage.classList.add('hidden');
            modalVideo.classList.add('hidden');
            modalVideo.pause();
    
            if (/\.(mp4|mov|avi|wmv)$/i.test(mediaUrl)) {
                modalVideoSource.src = mediaUrl;
                modalVideo.load();
                modalVideo.classList.remove('hidden');
            } else {
                modalImage.src = mediaUrl;
                modalImage.classList.remove('hidden');
            }
    
            modalCaption.textContent = caption;
            modalDate.textContent = createdAt;
            uploadDate.textContent = createdAt;
            likesCountEl.textContent = likeCount;
            postIdInput.value = postId;
    
            updateLikeButton();
            updateFormActions(postId);
            loadComments(postId);
    
            postModal.classList.remove('hidden');
            document.body.classList.add('modal-open');
        }
    
        function updateFormActions(postId) {
            if (editLink) editLink.href = `/posts/${postId}/edit`;
            if (archiveForm) archiveForm.action = `/posts/${postId}/archive`;
            if (deleteForm) deleteForm.action = `/posts/${postId}`;
        }
    
        function closePostModal() {
            postModal.classList.add('hidden');
            document.body.classList.remove('modal-open');
        }
    
        function updateLikeButton() {
            likeIcon.classList.toggle('fas', isLiked);
            likeIcon.classList.toggle('far', !isLiked);
            likeIcon.classList.toggle('liked', isLiked);
        }
    
        function toggleLike() {
            if (!currentPostId) return;
    
            isLiked = !isLiked;
            likesCount = isLiked ? likesCount + 1 : likesCount - 1;
    
            likesCountEl.textContent = likesCount;
            updateLikeButton();
    
            apiFetch(`/posts/${currentPostId}/like`, 'POST', { liked: isLiked })
                .catch(err => console.error('Error:', err));
        }
    
        function loadComments(postId) {
            commentsSection.innerHTML = '<p class="text-center text-gray-500 py-4">Loading comments...</p>';
    
            fetch(`/posts/${postId}/comments`)
                .then(response => response.json())
                .then(comments => {
                    commentsSection.innerHTML = '';
    
                    if (!comments.length) {
                        commentsSection.innerHTML = '<p class="text-center text-gray-500 py-4">No comments yet.</p>';
                        return;
                    }
    
                    comments.forEach(comment => {
                        const commentElement = document.createElement('div');
                        commentElement.className = 'flex mb-3';
    
                        const img = document.createElement('img');
                        img.src = comment.user.profile_picture ? `/storage/${comment.user.profile_picture}` : '/default.jpg';
                        img.className = 'w-8 h-8 rounded-full object-cover mr-2';
    
                        const div = document.createElement('div');
                        const p1 = document.createElement('p');
                        const usernameSpan = document.createElement('span');
                        usernameSpan.className = 'font-semibold text-gray-800 dark:text-white';
                        usernameSpan.textContent = comment.user.username || comment.user.name;
    
                        const contentSpan = document.createElement('span');
                        contentSpan.className = 'text-gray-700 dark:text-gray-300';
                        contentSpan.textContent = ` ${comment.content}`;
    
                        const p2 = document.createElement('p');
                        p2.className = 'text-xs text-gray-500 mt-1';
                        p2.textContent = formatCommentDate(comment.created_at);
    
                        p1.appendChild(usernameSpan);
                        p1.appendChild(contentSpan);
                        div.appendChild(p1);
                        div.appendChild(p2);
                        commentElement.appendChild(img);
                        commentElement.appendChild(div);
    
                        commentsSection.appendChild(commentElement);
                    });
                })
                .catch(err => {
                    console.error('Error:', err);
                    commentsSection.innerHTML = '<p class="text-center text-red-500 py-4">Failed to load comments.</p>';
                });
        }
    
        function formatCommentDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffSeconds = Math.floor((now - date) / 1000);
    
            if (diffSeconds < 60) return `${diffSeconds}s ago`;
            if (diffSeconds < 3600) return `${Math.floor(diffSeconds / 60)}m ago`;
            if (diffSeconds < 86400) return `${Math.floor(diffSeconds / 3600)}h ago`;
            if (diffSeconds < 604800) return `${Math.floor(diffSeconds / 86400)}d ago`;
            return date.toLocaleDateString();
        }
    
        function toggleDropdown() {
            if (!dropdownMenu) return;
            dropdownMenu.classList.toggle('hidden');
    
            if (!dropdownMenu.classList.contains('hidden') && !isDropdownListenerAdded) {
                document.addEventListener('click', closeDropdownOutside);
                isDropdownListenerAdded = true;
            }
        }
    
        function closeDropdownOutside(e) {
            const dropdownButton = document.querySelector('button[onclick="toggleDropdown()"]');
            if (dropdownMenu && !dropdownMenu.contains(e.target) && !dropdownButton.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
                document.removeEventListener('click', closeDropdownOutside);
                isDropdownListenerAdded = false;
            }
        }
    
        document.addEventListener('DOMContentLoaded', () => {
            // ✅ Auto-load FontAwesome if missing
            const fontAwesomeLoaded = Array.from(document.styleSheets).some(sheet => sheet.href?.includes('font-awesome'));
            if (!fontAwesomeLoaded) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
                document.head.appendChild(link);
            }
    
            if (commentForm) {
                commentForm.addEventListener('submit', e => {
                    e.preventDefault();
                    const commentText = commentTextarea.value.trim();
                    if (!commentText) return;
    
                    const postId = postIdInput.value;
    
                    apiFetch(`/posts/${postId}/comments`, 'POST', { content: commentText })
                        .then(res => res.json())
                        .then(() => {
                            commentTextarea.value = '';
                            loadComments(postId);
                        })
                        .catch(err => console.error('Error:', err));
                });
            }
    
            if (commentTextarea) {
                commentTextarea.addEventListener('input', function () {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            }
    
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && !postModal.classList.contains('hidden')) {
                    closePostModal();
                }
            });
        });
    </script>
    
    
</x-app-layout>