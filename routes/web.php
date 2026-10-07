<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Livewire\Catalog\ProductCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/about-us', [AboutController::class, 'index'])->name('about');
Route::get('/catalog', ProductCatalog::class)->name('catalog');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/category/{category:slug}', [PostController::class, 'category'])->name('posts.category');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/tentang-kami', fn (Request $request) => redirect('/about-us'.($request->getQueryString() ? '?'.$request->getQueryString() : ''), 301));
Route::get('/katalog', fn (Request $request) => redirect('/catalog'.($request->getQueryString() ? '?'.$request->getQueryString() : ''), 301));
Route::get('/produk/{product:slug}', fn (Request $request, string $product) => redirect(route('products.show', $product).($request->getQueryString() ? '?'.$request->getQueryString() : ''), 301));
Route::get('/blog/kategori/{category:slug}', fn (Request $request, string $category) => redirect(route('posts.category', $category).($request->getQueryString() ? '?'.$request->getQueryString() : ''), 301));
