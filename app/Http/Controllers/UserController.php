<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function show(string $name)
    {
        $user = User::where('name', $name)->first()->load(['articles.user', 'articles.likes', 'articles.tags']);
        $articles = $user->articles;
        return view('users.show', compact('user', 'articles'));
    }
    public function follow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['name' => $name];
    }
    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }
    public function likes(string $name)
    {
        $user = User::where('name', $name)->first()->load(['likes.user', 'likes.likes', 'likes.tags']);;
        $articles = $user->likes->sortByDesc('created_at');
        return view('users.likes', compact('user', 'articles'));
    }
    public function followers(string $name)
    {
        $user = User::where('name', $name)->first()->load('followings.followers');
        $followers = $user->followers->sortByDesc('created_at');
        return view('users.followers', compact('user', 'followers'));
    }
    public function followees(string $name)
    {
        $user = User::where('name', $name)->first()->load('followers.followers');
        $followees = $user->followings->sortByDesc('created_at');
        return view('users.followees', compact('user', 'followees'));
    }
    public function unregister()
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect('/');
        }
        User::where('id', $userId)->delete();
        return redirect('/');
    }
}
