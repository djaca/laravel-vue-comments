<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $pageId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pageId)
    {
        $comments = Comment::where('page_id', $pageId)
                           ->select([
                               'id',
                               'body',
                               'user_id',
                               'page_id',
                               'reply_id',
                               'created_at',
                               'votes'
                           ])->with('userVotes')->get();

        if (request()->wantsJson()) {
            return response()->json($comments);
        }

        return $comments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'reply_id' => 'filled',
            'page_id' => 'filled',
            'body' => 'required',
        ]);

        $comment = Comment::create($request->all());

        if ($request->wantsJson()) {
            return response()->json($comment);
        }

        return $comment;
    }

    /**
     * Vote
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Comment             $comment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function vote(Request $request, Comment $comment)
    {
        $request->validate([
            'user_id' => [
                'required',
                Rule::unique('comment_vote')->where(function ($query) use ($comment) {
                    return $query->where('comment_id', $comment->id);
                })
            ],
            'type' => 'required|in:up,down'
        ]);

        $comment->vote($request->only(['user_id', 'type']));

        $comment->load('userVotes');

        return response()->json($comment);
    }
}
