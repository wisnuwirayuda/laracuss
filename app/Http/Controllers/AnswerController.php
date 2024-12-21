<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Discussion;
use App\Http\Requests\Answer\StoreRequest;
use App\Http\Requests\Answer\UpdateRequest;

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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Get answer berdasarkan ID
        $answer = Answer::find($id);

        // Cek apakah data answer dengan id tersebut tidak ada
        if (!$answer) {
            // Jika tidak ada maka return page not found
            return abort(404);
        }
        
        $isOwnedByUser = $answer->user_id == auth()->id();
        
        // Cek apakah answer ini milik user yg sedang login
        if (!$isOwnedByUser) {
            // Jika bukan maka return page not found
            return abort(404);
        }
        
        // Return view dengan data answer
        return response()->view('pages.answers.form', [
            'answer' => $answer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        // Get answer berdasarkan ID
        $answer = Answer::find($id);

        // Cek apakah data answer dengan id tersebut tidak ada
        if (!$answer) {
            // Jika tidak ada maka return page not found
            return abort(404);
        }
        
        $isOwnedByUser = $answer->user_id == auth()->id();
        
        // Cek apakah answer ini milik user yg sedang login
        if (!$isOwnedByUser) {
            // Jika bukan maka return page not found
            return abort(404);
        }

        // Get request yg sudah tervalidasi
        $validated = $request->validated();

        // Update answer dengan data validated tadi
        $update = $answer->update($validated);

        // Cek apakah update berhasil
        if ($update) {
            // Jika berhasil maka return notif success dan redirect ke detail discussion dari answer tersebut
            session()->flash('notif.success', 'Answer updated successfully!');
            return redirect()->route('discussions.show', $answer->discussion->slug);
        }
        
        // Jika tidak berhasil maka lanjut ke bawah / ke kode abort
        // Return view dengan data answer
        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get answer berdasarkan ID
        $answer = Answer::find($id);

        // Cek apakah data answer dengan id tersebut tidak ada
        if (!$answer) {
            // Jika tidak ada maka return page not found
            return abort(404);
        }
        
        $isOwnedByUser = $answer->user_id == auth()->id();
        
        // Cek apakah answer ini milik user yg sedang login
        if (!$isOwnedByUser) {
            // Jika bukan maka return page not found
            return abort(404);
        }

        // Delete answer dengan data validated tadi
        $delete = $answer->delete();

        // Cek apakah delete berhasil
        if ($delete) {
            // Jika berhasil maka return notif success dan redirect ke detail discussion dari answer tersebut
            session()->flash('notif.success', 'Answer deleted successfully!');
            return redirect()->route('discussions.show', $answer->discussion->slug);
        }
        
        // Jika tidak berhasil maka lanjut ke bawah / ke kode abort
        // Return view dengan data answer
        return abort(500);
    }
}
