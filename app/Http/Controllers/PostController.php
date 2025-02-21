<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      title="To-Do List API",
 *      version="1.0.0",
 *      description="API untuk mengelola to-do list postingan media sosial"
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     in="header",
 *     name="X-API-KEY",
 *     securityScheme="api_key"
 * )
 */
class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all posts",
     *     tags={"Posts"},
     *     security={{"api_key": {}}},
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index()
    {
        return response()->json(Post::all());
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     security={{"api_key": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "brand", "platform", "due_date", "payment", "status"},
     *             @OA\Property(property="title", type="string", example="Promo Product X"),
     *             @OA\Property(property="brand", type="string", example="Brand X"),
     *             @OA\Property(property="platform", type="string", example="Instagram"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2025-03-01"),
     *             @OA\Property(property="payment", type="number", format="double", example=100.00),
     *             @OA\Property(property="status", type="string", example="pending")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Post created")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'due_date' => 'required|date',
            'payment' => 'required|numeric',
            'status' => 'required|string|max:50'
        ]);

        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Get a single post by ID",
     *     tags={"Posts"},
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function show($id)
    {
        return response()->json(Post::findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Update a post",
     *     tags={"Posts"},
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="brand", type="string", example="Updated Brand"),
     *             @OA\Property(property="platform", type="string", example="Twitter"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2025-04-01"),
     *             @OA\Property(property="payment", type="number", format="double", example=150.00),
     *             @OA\Property(property="status", type="string", example="completed")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Post updated"),
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json($post);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Delete a post",
     *     tags={"Posts"},
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Response(response=200, description="Post deleted"),
     *     @OA\Response(response=404, description="Post not found")
     * )
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(['message' => 'Post deleted']);
    }
}
