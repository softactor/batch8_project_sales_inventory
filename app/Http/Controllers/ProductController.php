<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('name', 'asc')
        ->when($request->find, function($q, $search){
            return $q->search($search);
        })
        ->paginate();
        return response()->json([
            'status' => 'success',
            'message' => 'Product List',
            'data' => ProductResource::collection($products)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'sku' => $request->sku,
            'cost' => $request->cost,
            'price' => $request->cost * $request->stock_quantity,
            'stock_quantity' => $request->stock_quantity,
            'reorder_level' => $request->reorder_level,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added',
            'data' => new ProductResource($product)
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Product foud',
            'data' => new ProductResource($product)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Product updated',
            'data' => new ProductResource($product)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted'
        ],200);
    }
}
