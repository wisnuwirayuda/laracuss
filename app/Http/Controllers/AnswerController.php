<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Discussion;
use App\Http\Requests\Answer\StoreRequest;

class AnswerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, $slug)
    {
        // Get request yang sudah tervalidasi
        $validated = $request->validated();

        // ke variable validated tambahkan user ID
        // Tambahkan juga discussion id berdasarkan discussion slug
        $validated['user_id'] = auth()->id();
        $validated['discussion_id'] = Discussion::where('slug', $slug)->first()->id;

        // Create answer
        $create = Answer::create($validated);

        // Jika create berhasil maka buat notif success dan redirect ke detail discussion
        if ($create) {
            session()->flash('notif.success', 'Your answer posted successfully');

            return redirect()->route('discussions.show', $slug);
        }

        // Jika tidak berhasil maka abort
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
