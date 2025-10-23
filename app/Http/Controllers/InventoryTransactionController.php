<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryTransactionRequest;
use App\Http\Resources\InventoryTransactionResource;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = InventoryTransaction::get();
        return response()->json([
            'status' => 'success',
            'message' => 'Inventory Transaction List',
            'data' => InventoryTransactionResource::collection($categories)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryTransactionRequest $request)
    {

        // update stock_quantity into products        
        // $product = Product::find($request->product_id);

        // $totalValue = ($request->quantity * $request->unit_cost);
        $inventory = InventoryTransaction::create([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'unit_cost' => $request->unit_cost,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);
        

        // if(in_array($request->type, ['purchase', 'return']))
        // {
            // $product->stock_quantity += $request->quantity;
            // $product->price += $totalValue;
            // $product->updateStock($request->quantity, $totalValue);
        // }else{
            // $product->stock_quantity -= $request->quantity;
            // $product->price -= $totalValue;
            // $product->updateStock(-$request->quantity, -$totalValue);
        // }

        // $product->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Inventory Transaction added',
            'data' => new InventoryTransactionResource($inventory)
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
