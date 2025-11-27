<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('viewAny', Category::class))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to view the list',
            ],401);
        }

        $categories = Category::get();
        return response()->json([
            'status' => 'success',
            'message' => 'Categories data',
            'data' => CategoryResource::collection($categories)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        if(!Gate::allows('create', Category::class))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to create category',
            ],401);
        }

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
        if(!Gate::allows('view', Category::class))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to show category',
            ],401);
        }

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

        if(!Gate::allows('update', Category::class))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to update category',
            ],401);
        }

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
        if(!Gate::allows('delete', Category::class))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to delete category',
            ],401);
        }

        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category data successfully deleted'
        ],200);
    }
}
