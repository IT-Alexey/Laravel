<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\Tag;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller {

    public function index() {
        if (\Auth::check()) {
            
        }
        $posts = Post::paginate(2);
        $popularPosts = Post::orderBy('views', 'desc')->take(3)->get();
        $featuredPosts = Post::where('is_featured', 1)->take(3)->get();
        $recentPosts = Post::orderBy('date', 'desc')->take(4)->get();
        $categories = Category::all();

        return view('pages.index', [
            'posts' => $posts,
            'popularPosts' => $popularPosts,
            'featuredPosts' => $featuredPosts,
            'recentPosts' => $recentPosts,
            'categories' => $categories
        ]);
    }

    public function show($id) {
        $post = Post::where('id', $id)->firstOrFail();
        return view('pages.show', compact('post'));
    }

    public function tag($id) {
        $tag = Tag::where('id', $id)->firstOrFail();
        $posts = $tag->posts()->paginate(2);
        return view('pages.list', compact('posts'));
    }

    public function category($id) {
        $category = Category::where('id', $id)->firstOrFail();
        $posts = $category->posts()->paginate(2);
        return view('pages.list', compact('posts'));
    }

}
