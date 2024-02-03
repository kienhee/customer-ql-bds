<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SavePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavePostController extends Controller
{
    public function index()
    {
        $data = SavePost::where('user_id', Auth::id())->OrderBy('created_at', 'DESC')->get();
        $news = [];
        foreach ($data as $item) {
            if ($item->post) {
                $news[] = $item->post;
            }
        }
        return view('admin.save-post.index', compact('news'));
    }
    public function savePost(Request $request)
    {
        if ($request->has('post_id')) {
            $checkPost = Post::where('id', $request->post_id)->first();
            if (!$checkPost) {
                return false;
            }
            $checkPostExist = SavePost::where('user_id', Auth::id())->where('post_id', $checkPost->id)->first();
            if (!$checkPostExist) {
                return SavePost::insert(['user_id' => Auth::id(), 'post_id' => $checkPost->id]);
            } else {
                return true;
            }
            return false;
        }
    }
    public function removePost(Request $request)
    {
        if ($request->has('post_id')) {
            $checkTour = Post::where('id', $request->post_id)->first();
            if (!$checkTour) {
                return false;
            }
            return SavePost::where('user_id', Auth::id())->where('post_id', $checkTour->id)->delete();
        }
        return false;
    }
}
