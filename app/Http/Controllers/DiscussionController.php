<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Discussion;
use App\Http\Requests\Discussion\StoreRequest;
use Str;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('pages.discussions.form', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        // Mendapatkan dulu data dari form request yang sudah valid
        // Get data category berdasarkan slug nya
        // Mendapatkan ID Category
        // Masukkan User ID ke array validated
        // Menambahkan slug discussions berdasarkan title (title: create validation laravel, slug: create-validation-laravel-timestamp())
        // Membuat content_preview berdasarkan content (if content > 120 karakter)

        $validated = $request->validated();
        $categoryId = Category::where('slug', $validated['category_slug'])->first()->id;

        $validated['category_id'] = $categoryId;
        $validated['user_id']     = auth()->id();
        $validated['slug']        = Str::slug($validated['title']) . '-' . time();

        // strip_tags berfungsi untuk menghapus tag HTML pada content
        $stripContent                   = strip_tags($validated['content']);
        $isContentLong                  = strlen($stripContent) > 120;
        $validated['content_preview']   = $isContentLong ? (substr($stripContent, 0, 120) . '...') : $stripContent;

        $create = Discussion::create($validated);

        if ($create) {
            session()->flash('notif.success', 'Discussion created  successfully!');
            return redirect()->route('discussions.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
