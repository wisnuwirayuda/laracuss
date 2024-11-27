<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\Answer;

class LikeController extends Controller
{
    public function discussionLike(string $discussionSlug) 
    {
        // Get discussion berdasarkan slug dari parameter
        $discussion = Discussion::where('slug', $discussionSlug)->first();

        // Like discussion dengan model tadi
        $discussion->like();

        // Return json
        // Isi jsonnya adalah likeCount / total semua like dari discussion tersebut 
        return response()->json([
            'status'    => 'success',
            'data'      => [
                'likeCount' => $discussion->likeCount
            ],
        ]);
    }

    public function discussionUnlike(string $discussionSlug) 
    {
        // Get discussion berdasarkan slug dari parameter
        $discussion = Discussion::where('slug', $discussionSlug)->first();

        // Unlike discussion dengan model tadi
        $discussion->unlike();

        // Return json
        // Isi jsonnya adalah likeCount / total semua like dari discussion tersebut 
        return response()->json([
            'status'    => 'success',
            'data'      => [
                'likeCount' => $discussion->likeCount
            ],
        ]);
    }

    public function answerLike(string $answerId) 
    {
        $answer = Answer::find($answerId);

        $answer->like();

        return response()->json([
            'status'    => 'success',
            'data'      => [
                'likeCount' => $answer->likeCount
            ]
        ]);
    }

    public function answerUnlike(string $answerId) 
    {
        $answer = Answer::find($answerId);

        $answer->unlike();

        return response()->json([
            'status'    => 'success',
            'data'      => [
                'likeCount' => $answer->likeCount
            ]
        ]);
    }
}
