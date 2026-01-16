<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Post;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $blogs = Post::where('delete_flag', false)->get();
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
            $blog = Post::findOrFail($id);
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

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('blog::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
