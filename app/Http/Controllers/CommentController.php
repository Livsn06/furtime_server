<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $comment = Comment::all();
        return response()->json(["message" => "success", "data" => $comment], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $user = $request->user();
        $comment = Comment::create([
            'body' => $request->body,
            'post_id' => $request->post_id,
            'user_id' => $user->id
        ]);
        return response()->json(["message" => "success", "data" => $comment], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json(["message" => "success", "data" => $comment], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
        $comment->update($request->all());
        return response()->json(["message" => "success", "data" => $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
        $comment->delete();
        return response()->json(["message" => "success", "data" => $comment], 200);
    }


    public function getCommentByPostId($id)
    {
        $comment = Comment::with('user')->where('post_id', $id)->orderBy('id', 'desc')->get();
        return response()->json(["message" => "success", "data" => $comment], 200);
    }
}
