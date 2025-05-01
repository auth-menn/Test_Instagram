<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = Post::where('user_id', Auth::id())
                        ->where('is_archived', true)
                        ->latest()
                        ->get();

        return view('archive.index', compact('archives'));
    }

    public function restore($id)
    {
        $post = Post::findOrFail($id);

        if ($post->is_archived) {
            $post->update(['is_archived' => false]);

            return redirect()->route('archives.index')->with('success', 'Post has been restored successfully.');
        }

        return redirect()->route('archives.index')->with('error', 'Post was not archived.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('archives.index')->with('success', 'Post has been deleted permanently.');
    }
}
