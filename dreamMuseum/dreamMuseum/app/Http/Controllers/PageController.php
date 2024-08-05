<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Li;

class PageController extends Controller
{
    public function index($id = 0) {

        $categories = Category::get();

        $lastPosts = Post::latest();

        if ($id) {
            $lastPosts->where('category_id', $id);
        }

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        return view('index', compact('categories', 'chat'), ['posts' => $lastPosts->get()]);
    }

    public function post($id) {

        $post = Post::findOrFail($id);

        $likes = Like::where('post_id', $id)->get()->count();

        $carbonDate = new Carbon(Post::find($id)->created_at);

        $model = Post::find($id)->model_url;

        $comments = Comment::where('post_id', $id)->get();

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        return view('post', ['date' => $carbonDate], compact('post', 'model', 'likes', 'comments', 'chat'));
    }

    public function profile() {

        $id = Auth::user()->id;

        $posts = Post::where('user_id', $id)->latest();

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        return view('profile', ['posts' => $posts->get()], compact('chat'));
    }

    public function edit() {

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        return view('edit-profile', compact('chat'));

    }

    public function favourites() {

        $posts = Auth::user()->like;

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        return view('profile', ['posts' => $posts], compact('chat'));
    }

    public function profileUser($id) {

        $user = User::find($id);

        $posts = Post::where('user_id', $id)->get();

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        return view('user-profile', ['user' => $user], compact('chat', 'posts'));
    }

    public function support($id) {

        $route = $id;

        $chats = Chat::get();

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        $admin = User::find(1);

            return view('chat', compact('admin', 'chat', 'chats' ,'route'));
    }

    public function editPost($id) {

        $categories = Category::get();

        $post = Post::find($id);

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        return view('edit-post', ['categories' => $categories], compact('post', 'chat'));
    }

    public function reg() {
        return view('registration');
    }

    public function auth() {
        return view('authorization');
    }

    public function password() {
        return view('forgot-password');
    }

    public function addModel() {

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        $categories = Category::get();

        return view('add-model', compact('categories', 'chat'));
    }

    public function reset(Request $request) {

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        return view('reset-password', ['request' => $request], compact('chat'));
    }
}
