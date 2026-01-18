<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Reply;
use Auth;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        try {
            $reply = new Reply();
            $reply->comment_id = $request->comment_id;
            $reply->reply = $request->reply;
            $reply->user_id = Auth::user()->id;
            $reply->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Reply created successfully.',
                    'data' => $reply
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
            $reply = Reply::where('id', $id)->where('delete_flag', false)->first();
            if(!$reply) {
                return response()->json([
                        'success' => false, 
                        'message' => 'Reply not found.',
                        'data' => []
                ], 404);
            }
            $reply->reply = $request->reply;
            $reply->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Reply updated successfully.',
                    'data' => $reply
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
            $reply = Reply::find($id);
            if(!$reply) {
                return response()->json([
                        'success' => false, 
                        'message' => 'Reply not found.',
                        'data' => []
                ], 404);
            }
            $reply->delete_flag = true;
            $reply->save();
            return response()->json([
                    'success' => true, 
                    'message' => 'Reply deleted successfully.',
                    'data' => $reply
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
            $reply = Reply::where('id', $id)->where('delete_flag', false)->first();
            return response()->json([
                    'success' => true, 
                    'data' => $reply
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