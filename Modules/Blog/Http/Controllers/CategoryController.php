<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Entities\Category;
use Modules\Blog\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index(){
        try {
            $categories = Category::where('delete_flag', false)->get();
            return response()->json([
                'success' => true, 
                'message' => 'Categories retrieved successfully.',
                'data' => $categories
            ], 200);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = new Category();
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully'
            ], 201);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try{
            $category = Category::where('id', $id)->where('delete_flag', false)->first();

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found.',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Category retrieved successfully.',
                'data' => $category
            ], 200);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::where('id', $id)->where('delete_flag', false)->first();
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully'
            ], 200);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            $category->delete_flag = true;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ], 200);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}