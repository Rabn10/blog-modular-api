<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Comment;
use Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $comment = new Comment();
            $comment->post_id = $request->post_id;
            $comment->content = $request->content;
            $comment->user_id = Auth::user()->id;
            $comment->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Comment created successfully.',
                    'data' => $comment
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

    public function update(Request $request, $id)
    {
        try {
            $comment = Comment::where('id', $id)->where('delete_flag', false)->first();
            if (!$comment) {
                return response()->json([
                        'success' => false, 
                        'message' => 'Comment not found.',
                        'data' => []
                ], 404);
            }
            $comment->content = $request->content;
            $comment->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Comment updated successfully.',
                    'data' => $comment
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

    public function show($id)
    {
        try {
            $comment = Comment::where('id', $id)->where('delete_flag', false)->first();
            return response()->json([
                    'success' => true, 
                    'data' => $comment
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

    public function destroy($id)
    {
        try {
            $comment = Comment::find($id);
            if (!$comment) {
                return response()->json([
                        'success' => false, 
                        'message' => 'Comment not found.',
                        'data' => []
                ], 404);
            }
            $comment->delete_flag = true;
            $comment->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Comment deleted successfully.',
                    'data' => []
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