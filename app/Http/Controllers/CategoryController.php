<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();
        return response()->json([
            'status' => 'success',
            'message' => 'Category created',
            'data' => CategoryResource::collection($categories)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created',
            'data' => new CategoryResource($category)
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Category data found',
            'data' => new CategoryResource($category)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Category data successfully updated',
            'data' => new CategoryResource($category)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category data successfully deleted'
        ],200);
    }
}
