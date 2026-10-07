<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->select(['id', 'post_category_id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'reading_time_minutes', 'status'])
            ->published()
            ->with('category:id,name,slug')
            ->latest('published_at')
            ->paginate(9);

        $categories = PostCategory::withCount(['posts' => fn ($q) => $q->published()])->get();

        return view('pages.blog-index', compact('posts', 'categories'));
    }

    public function show(Post $post): View
    {
        abort_unless(Post::published()->whereKey($post)->exists(), 404);

        $relatedPosts = Post::query()
            ->select(['id', 'post_category_id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'reading_time_minutes', 'status'])
            ->published()
            ->where('post_category_id', $post->post_category_id)
            ->whereKeyNot($post->id)
            ->orderByDesc('published_at')
            ->orderBy('id')
            ->take(3)
            ->get();

        $post->load(['category:id,name,slug', 'author:id,name']);

        return view('pages.post-detail', compact('post', 'relatedPosts'));
    }

    public function category(PostCategory $category): View
    {
        $posts = $category->posts()
            ->select(['id', 'post_category_id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'reading_time_minutes', 'status'])
            ->published()
            ->with('category:id,name,slug')
            ->latest('published_at')
            ->paginate(9);

        $categories = PostCategory::withCount(['posts' => fn ($q) => $q->published()])->get();
        $currentCategory = $category;

        return view('pages.blog-index', compact('posts', 'categories', 'currentCategory'));
    }
}
