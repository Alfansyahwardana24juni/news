<?php

namespace App\Http\Controllers;

use App\Models\ArticleNews;
use App\Models\Category;
use App\Models\Author;
use App\Models\BannerAdvertisement;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //Ini adalah bagian Index
    public function index(){
        $categories = Category::all();

        $articles = ArticleNews::with(['category'])
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(3)
        ->get();

        $featured_articles = ArticleNews::with(['category'])
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->take(3)
        ->get();

        $authors = Author::all();

        $bannerads = BannerAdvertisement::where('is_active', 'active')
        ->inRandomOrder()
        ->first();

        $entertainment_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(6)
        ->get();

        $entertainment_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->first();

        $business_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Business');
        })
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(6)
        ->get();

        $business_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Business');
        })
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->first();

        $automotive_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Automotive');
        })
        ->where('is_featured', 'not_featured')
        ->latest()
        ->take(6)
        ->get();

        $automotive_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Automotive');
        })
        ->where('is_featured', 'featured')
        ->inRandomOrder()
        ->first();

        return view('front.index', compact('automotive_articles', 'automotive_featured_articles', 'business_articles', 'business_featured_articles','entertainment_featured_articles','entertainment_articles','categories', 'articles', 'authors', 'featured_articles', 'bannerads'));
    }

    // Ini adalah bagian Category
    public function category(Category $category) {
        $categories = Category::all();
    
        $bannerads = BannerAdvertisement::where('is_active', 'active')
            ->inRandomOrder()
            ->first();
    
        return view('front.category', compact('category', 'categories', 'bannerads'));
    }

    // Ini adalah bagian Author
    public function author(Author $author) {
        $categories = Category::all();

        $bannerads = BannerAdvertisement::where('is_active', 'active')
            ->inRandomOrder()
            ->first();
    
        return view('front.author', compact('author', 'categories', 'bannerads'));
    }

    //Ini adalah bagian Search

    public function search(Request $request) {
        $request->validate([
            'keyword' => ['required', 'string', 'max:255'],
        ]);
    
        $categories = Category::all();
    
        $keyword = $request->keyword;
    
        $articles = ArticleNews::with(['category', 'author'])
            ->where('name', 'like', '%' . $keyword . '%')
            ->paginate(6);
    
        return view('front.search', compact('articles', 'keyword', 'categories'));
    }
}

