<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpeg,jpg,png,mp4,mov,avi,wmv|max:10240',
            'caption' => 'nullable|string|max:255',
        ]);
        
        $mediaPath = $request->file('media')->store('posts', 'public');
        $extension = $request->file('media')->getClientOriginalExtension();
        $fileType = in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'wmv']) ? 'video' : 'image';

        Post::create([
            'user_id' => Auth::id(),
            'media' => $mediaPath,
            'caption' => $request->caption,
            'file_type' => $fileType,
        ]);
        
        return redirect()->route('profile.show', Auth::id())->with('status', 'Post successfully created!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($post->media && Storage::disk('public')->exists($post->media)) {
            Storage::disk('public')->delete($post->media);
        }

        $post->delete();

        return redirect()->back()->with('status', 'Post berhasil dihapus.');
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $post->update([
            'caption' => $request->caption,
        ]);

        return redirect()->route('profile.show', Auth::id())->with('status', 'Post berhasil diperbarui.');
    }
    
    public function archiveIndex()
    {
        $archives = Post::where('is_archived', true)->get();

        return view('archive.index', compact('archives'));
    }

    public function archive(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->update(['is_archived' => true]);

        return redirect()->route('archives.index')->with('success', 'Postingan berhasil diarsipkan.');
    }

    
}


