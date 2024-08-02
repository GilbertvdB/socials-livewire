<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {   
        $posts = Post::all();
        return view('comments', [
            'posts' => $posts
        ]);
    }
}
