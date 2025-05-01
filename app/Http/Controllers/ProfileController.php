<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile(): View
    {
        $user = User::findOrFail(Auth::id());

        $posts = Post::where('user_id', $user->id)
                     ->where('is_archived', false)
                     ->latest()
                     ->get();

        return view('profile.index', compact('user', 'posts'));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $user = User::find(Auth::id());
    
        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
    
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
    
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
    
        $user->save();
    
        return redirect()->route('profile.show')->with('status', 'profile-updated');
    }
    
    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
