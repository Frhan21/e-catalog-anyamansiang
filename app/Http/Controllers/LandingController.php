<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $featured = Product::query()
            ->select(['id', 'category_id', 'sku', 'name', 'slug', 'price', 'availability_status', 'primary_image', 'is_featured', 'is_active'])
            ->active()
            ->featured()
            ->with('category:id,name,slug')
            ->take(6)
            ->get();

        $latestPosts = Post::query()
            ->select(['id', 'post_category_id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'reading_time_minutes', 'status'])
            ->published()
            ->with('category:id,name,slug')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.landing', compact('featured', 'latestPosts'));
    }
}
