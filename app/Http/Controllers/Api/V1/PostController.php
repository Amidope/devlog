<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $service
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->service->getPostsPage($request->input('page', 1));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = $this->service->create($request->validated());
        return response()->json($post, status: 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->service->update($request->validated(), $post);
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->service->delete($post);
        return response(status: 204);
    }
}
