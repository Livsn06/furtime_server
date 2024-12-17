<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //GET POST BY DATE LATEST
        $post = Post::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json(["message" => "success", "data" => $post], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $user = $request->user();

        $images = $this->imagePath($request);

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $user->id,
            'images' => $images ?? null
        ]);

        return response()->json(["message" => "success"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

    //add images
    private function imagePath($request)
    {
        if ($request->images == null) {
            print_r("null");
            return null;
        }

        $uploadedFiles = '';

        $file = $request->file('images');
        // Extract file extension
        $fileExt = $file->getClientOriginalExtension();
        // Generate the new file name
        $fileName = time() . "_{$request->title}." . $fileExt;
        // Store the file
        $path = $file->storeAs('posts_images', $fileName, 'public');
        $uploadedFiles = $path;

        return $uploadedFiles;
    }
}
