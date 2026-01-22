<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostLike;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Http\Requests\BlogRequest;

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

    public function store(BlogRequest $request)
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

    public function update(BlogRequest $request, $id)
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

    public function statusupdate(Request $request, $id)
    {
        try {
            $blog = Post::where('id', $id)->where('delete_flag', false)->first();
            if (!$blog) {
                return response()->json([
                        'success' => false, 
                        'message' => 'Blog not found.',
                        'data' => []
                ], 404);
            }
            $blog->is_active = $request->is_active;
            $blog->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Blog status updated successfully.',
                    'data' => $blog
            ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                    'success' => false, 
                    'message' => $th->getMessage(),
                    'data' => []
            ]);
        }
    }

    public function PostLike(Request $request, $id)
    {
        try {
            $blog = Post::where('id', $id)->where('delete_flag', false)->first();
            $postLike = PostLike::where('post_id', $blog->id)->where('user_id', Auth::user()->id)->first();
            if($postLike) {
                return response()->json([
                        'success' => false, 
                        'message' => 'Blog already liked.',
                        'data' => []
                ], 404);
            }
            if (!$blog) {
                return response()->json([
                        'success' => false, 
                        'message' => 'Blog not found.',
                        'data' => []
                ], 404);
            }
            $postLike = new PostLike();
            $postLike->post_id = $blog->id;
            $postLike->user_id = Auth::user()->id;
            $postLike->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Blog liked successfully.',
                    'data' => $postLike
            ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                    'success' => false, 
                    'message' => $th->getMessage(),
                    'data' => []
            ]);
        }
    }
}
