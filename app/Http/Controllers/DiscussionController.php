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
    public function index(Request $request)
    {
        // Load semua discussion
        // Eager load relationship/relasi
        // Apakah ada request data "search"
        // Jika ada maka load discussion dengan kata kunci title dan content yang nilainya seperti nilai "search"
        // return page index beserta data
        // Data yang di pass ke view adalah discussion yang sudah disort dengan created at menurun, pagination per 10 / 20
        // Data all category

        $discussions = Discussion::with('user', 'category');

        if ($request->search) {
            $discussions->where('title', 'like', "%$request->search%")
            ->orWhere('content', 'like', "%$request->search%");
        }

        return response()->view('pages.discussions.index', [
            'discussions' => $discussions->orderBy('created_at', 'desc')->paginate(10)->withQueryString(),
            'categories'  => Category::all(),
            'search'      => $request->search,
        ]);
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
    public function show(string $slug)
    {
        // Mendapatkan discussion berdasarkan slug, dan eager load user dan category nya
        // Get All Category
        $discussion = Discussion::with(['user', 'category'])->where('slug', $slug)->first();
        
        // Return response
        return response()->view('pages.discussions.show', [
            'discussion' => $discussion,
            'categories' => Category::all(),
        ]);
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
