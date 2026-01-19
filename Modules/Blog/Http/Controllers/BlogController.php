<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Post;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $blogs = Post::where('delete_flag', false)->with('category')->get();
            return response()->json([
                    'success' => true, 
                    'message' => 'Blogs retrieved successfully.',
                    'data' => $blogs
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                    'success' => false, 
                    'message' => $th->getMessage(),
                    'data' => []
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $blog  = new Post();
            $blog->title = $request->title;
            $blog->slug = $request->slug;
            $blog->content = $request->content;
            $blog->user_id = Auth::user()->id;
            $blog->category_id = $request->category_id;
            $blog->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Blog created successfully.',
                    'data' => $blog
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                    'success' => false, 
                    'message' => $th->getMessage(),
                    'data' => []
            ]);
        }
    }

    public function show($id)
    {
        try {
            $blog = Post::where('id', $id)->where('delete_flag', false)->with('category')->first();
            return response()->json([
                    'success' => true, 
                    'data' => $blog
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                    'success' => false, 
                    'message' => $th->getMessage(),
                    'data' => []
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $blog = Post::find($id);
            if (!$blog) {
                return response()->json([
                        'success' => false, 
                        'message' => 'Blog not found.',
                        'data' => []
                ], 404);
            }
            $blog->title = $request->title;
            $blog->slug = $request->slug;
            $blog->content = $request->content;
            $blog->category_id = $request->category_id;
            $blog->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Blog updated successfully.',
                    'data' => $blog
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                    'success' => false, 
                    'message' => $th->getMessage(),
                    'data' => []
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $blog = Post::find($id);
            if (!$blog) {
                return response()->json([
                        'success' => false, 
                        'message' => 'Blog not found.',
                        'data' => []
                ], 404);
            }
            $blog->delete_flag = true;
            $blog->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Blog deleted successfully.',
                    'data' => []
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                    'success' => false, 
                    'message' => $th->getMessage(),
                    'data' => []
            ]);
        }
    }
}
