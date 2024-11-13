<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Discussion;

class CategoryController extends Controller
{
    public function show($categorySlug) 
    {
        // Get category berdasarkan categorySlug
        $category = Category::where('slug', $categorySlug)->first();
        
        // Cek apakah data category diatas ada
        // Jika category tidak ada maka return abort 404
        if (!$category) {
            return abort(404);
        }

        // Buat query discussion, eager load user dan category, get category berdasarkan ID Category diatas
        // Discussionnya di sort by created at menurun
        // Dipaginasi 10
        $discussions = Discussion::with(['user', 'category'])
            ->where('category_id', $category->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Lalu return view  nya dengan semua variable diatas
        return response()->view('pages.discussions.index', [
            'discussions'   => $discussions,
            'categories'    => Category::all(),
            'withCategory'  => $category
        ]);
    }
}
