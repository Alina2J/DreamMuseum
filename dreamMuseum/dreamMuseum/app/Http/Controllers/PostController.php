<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ZanySoft\Zip\Zip;
use ZipArchive;

class PostController extends Controller
{
    public function search(Request $request) {

        $categories = Category::all();

        $search = $request->input('search');

        $posts = Post::where('title', 'like', '%'.$search.'%')->get();

        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();

        return view('search',compact('categories', 'posts', 'search', 'chat') );
    }

    public function favourites($id) {

       Auth::user()->like()->toggle($id);

        return redirect()->back();
    }

    public function delete($id) {

        Like::where('post_id', $id)->delete();

        Comment::where('post_id', $id)->delete();

        Post::find($id)->delete();

        File::deleteDirectory(public_path('/storage/models/' . Auth::id(). '/'. $id));

        if (Auth::user()->isAdmin()){
            return redirect()->route('main-page');
        }

        return redirect()->route('profile');

    }


    public function comment(Request $request, $id) {

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $user_id = Auth::user()->id;

        $commentInfo = $request->all();

        $comment = new Comment();
        $comment->text = $commentInfo['comment'];
        $comment->user_id = $user_id;
        $comment->post_id = $id;

        $comment->save();

        return redirect()->back();

    }

    public function deleteComment($id) {

        Comment::find($id)->delete();

        return redirect()->back();

    }


    public function editPost(Request $request, $id) {

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'sometimes|nullable|mimes:jpeg,png',
            'category' => 'required'
        ]);

        $post = Post::find($id);
        $photo = $post->img_url;
        if ($request->file('image') == null) {
            $post->img_url = $photo;
        }else{
            $post->img_url = $request->file('image')->store('uploads', 'public');
        }
        $post->description = $request->input('description');
        $post->category_id = $request->input('category');
        $post->title = $request->input('title');

        $post->save();

        return redirect()->route('single-post', $post->id);

    }

    public function addModel(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'file' => 'required',
            'file_type' => 'required',
            'category' => 'required',
            'image' => 'required|mimes:jpeg,png',
            'description' => 'required|string',
        ]);

        // Получаем выбранное значение из select
        $fileType = $request->input('file_type');

        // Получаем файл из запроса
        $file = $request->file('file');

        // Получаем расширение файла
        $fileExtension = $file->getClientOriginalExtension();

        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->category_id = $request->input('category');
        $post->model_type = $request->input('file_type');
        $post->img_url = $request->file('image')->store('uploads', 'public');

        $path = public_path().'/storage/models/' . Auth::id(). '/'. $post->title;
        File::makeDirectory($path, $mode = 0777, true, true);

        $pathTextures = public_path().'/storage/models/' . Auth::id(). '/'. $post->title. '/textures/';
        File::makeDirectory($pathTextures, $mode = 0777, true, true);

        $textures = [];
        if ($request->hasFile('textures')) {
            foreach ($request->file('textures') as $key => $texture) {
                $texture_name = $texture->getClientOriginalName();
                $textures[] = $texture->storeAs('/models/' . Auth::id() . '/' . $post->title . '/textures/', $texture_name, 'public');
            }
        }

        if($fileType === $fileExtension) {
            if ($post->model_type === 'gltf') {
                $file = $request->file('files');
                $fileName = $file->getClientOriginalName();
                $post->model_url = $request->file('files')->storeAs('/models/'.Auth::id().'/'.$post->title, $fileName,  'public');
                $post->model_url = $request->file('file')->store('/models/'.Auth::id().'/'.$post->title, 'public');
            } else {

                $file = $request->file('file');
                $name = Carbon::now()->format('Y-m-d')."-".strtotime(Carbon::now()).".".$file->getClientOriginalExtension();
                $post->model_url = $file-> storeAs('/models/'.Auth::id().'/'.$post->title, $name, 'public'); //save the file to temporary
            }
        } else {
            return back()->withErrors([
                'file_type' => 'Несовподают модель и выбранный тип файлы'
            ]);
        }

        $post->user_id =  Auth::user()->id;
        $post->save();

        $model = Post::find($post->id);

        $path = public_path().'/storage/models/' . Auth::id(). '/'. $model->id;
        File::makeDirectory($path, $mode = 0777, true, true);

        $pathTextures = public_path().'/storage/models/' . Auth::id(). '/'. $model->id. '/textures/';
        File::makeDirectory($pathTextures, $mode = 0777, true, true);

        $textures = [];
        if ($request->hasFile('textures')) {
            foreach ($request->file('textures') as $key => $texture) {
                $texture_name = $texture->getClientOriginalName();
                $textures[] = $texture->storeAs('/models/' . Auth::id() . '/' . $model->id . '/textures/', $texture_name, 'public');
            }
        }

        if($fileType === $fileExtension) {
            if ($post->model_type === 'gltf') {
                $file = $request->file('files');
                $fileName = $file->getClientOriginalName();
                $model->model_url = $request->file('files')->storeAs('/models/' . Auth::id() . '/' . $model->id, $fileName, 'public');
                $model->model_url = $request->file('file')->store('/models/' . Auth::id() . '/' . $model->id, 'public');
            } else {

                $file = $request->file('file');
                $name = Carbon::now()->format('Y-m-d') . "-" . strtotime(Carbon::now()) . "." . $file->getClientOriginalExtension();
                $model->model_url = $file->storeAs('/models/' . Auth::id() . '/' . $model->id, $name, 'public'); //save the file to temporary
            }
        }else {
            return back()->withErrors([
                'file_type' => 'Несовподают модель и выбранный тип файлы'
            ]);
        }

        File::deleteDirectory(public_path('/storage/models/' . Auth::id(). '/'. $post->title));

        $model->save();

        return redirect()->route('single-post', $post->id);
    }

    public function loadModel($id) {

        $post = Post::find($id);

        $zip = new ZipArchive();
        $fileName = $post->title.'.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path('storage/models/' .$post->user->id. '/'. $post->id));
            $textures = File::files(public_path('storage/models/' .$post->user->id. '/'. $post->id . '/textures/'));
            foreach ($files as $value) {
                foreach ($textures as $texture) {
                    $relative = basename($texture);
                    $zip->addFile($texture, $relative);
                }
                $relative = basename($value);
                $zip->addFile($value, $relative);
            }
            $zip->close();
        }

        return response()->download(public_path($fileName));
    }

}
