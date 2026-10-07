<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        abort_if(! $product->is_active, 404);

        $product->increment('views_count');
        $product->load(['category:id,name,slug', 'images:id,product_id,image_path,sort_order']);

        $related = Product::query()
            ->select(['id', 'category_id', 'sku', 'name', 'slug', 'price', 'availability_status', 'primary_image', 'is_active'])
            ->active()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->with('category:id,name,slug')
            ->take(4)
            ->get();

        return view('pages.product-detail', compact('product', 'related'));
    }
}
