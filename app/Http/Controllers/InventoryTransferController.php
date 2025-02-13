<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\InventoryTransfer;
use App\Models\InventoryItem;
use App\Models\ProductQuantity;
use App\Models\StoreInventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InventoryTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Gate::allows('view inventory_transfer')) {
            abort(403);
        }
        $branches = Branch::where('status','Active')->get();
        return view('inventory-transfer.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    public function InventoryTransferItems(Request $request)
    {
        $transferData = $request->all();
        $fromStoreId = $transferData['from_store_id'];
        $toStoreId = $transferData['to_store_id'];
        $items = $transferData['items'];
    
        $inventoryTransfer = InventoryTransfer::create([
            'sent_from' => $fromStoreId,
            'sent_to'   => $toStoreId,
            'sent_by'   => Auth::id()
        ]);
    
        foreach ($items as $value) {
            $productQuantityId = $value['product_quantity_id'];
            $quantity = $value['quantity'];
    
            $productQuantity = ProductQuantity::find($productQuantityId);
            if ($productQuantity) {
                $productQuantity->quantity = $productQuantity->quantity - $quantity;
                $productQuantity->save();
            } 

            $existingInventoryItem = InventoryItem::where([
                'inventroy_transfer_id' => $inventoryTransfer->id,
                'product_id'            => $value['product_id'],
                'product_quantity_id'   => $productQuantityId,
                'product_color_id'      => $value['color_id'],
                'product_size_id'       => $value['size_id'],
                'brand_id'              => $value['brand_id'],
            ])->first();

            if ($existingInventoryItem) {
                $existingInventoryItem->quantity += $quantity;
                $existingInventoryItem->save();
            } else {
                InventoryItem::create([
                    'inventroy_transfer_id' => $inventoryTransfer->id,
                    'product_id'            => $value['product_id'],
                    'product_quantity_id'   => $productQuantityId,
                    'product_color_id'      => $value['color_id'],
                    'product_size_id'       => $value['size_id'],
                    'brand_id'              => $value['brand_id'],
                    'quantity'              => $quantity,
                ]);
            }
    
            $storeInventory = StoreInventory::where([
                'store_id'             => $toStoreId,
                'product_quantity_id'  => $productQuantityId,
            ])->first();
    
            if ($storeInventory) {
                $storeInventory->update([
                    'quantity'       => $storeInventory->quantity + $quantity,
                    'total_quantity' => $storeInventory->total_quantity + $quantity,
                ]);
            } else {
                StoreInventory::create([
                    'store_id'              => $toStoreId,
                    'product_id'            => $value['product_id'],
                    'product_quantity_id'   => $productQuantityId,
                    'product_color_id'      => $value['color_id'],
                    'product_size_id'       => $value['size_id'],
                    'brand_id'              => $value['brand_id'],
                    'quantity'              => $quantity,
                    'total_quantity'        => $quantity
                ]);
            }
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Items transferred successfully.'
        ]);
    }


    public function inventoryHistory()
    {
        $inventory_transfer = InventoryTransfer::with('sentFrom', 'sentTo', 'sentBy')->get();
       
        foreach($inventory_transfer as $transfer)
        {       
            $inventory_transfer->total_quantity = InventoryItem::where('inventroy_transfer_id', $transfer->id)
                ->sum('quantity');
        }
       
        return view('inventory-transfer.history', ['inventory_transfer' => $inventory_transfer]);
    }


   
    public function inventoryTransferShow($id)
    {
        
        $inventoryTransfer = InventoryTransfer::with(
            'sentFrom', 
            'sentTo', 
            'sentBy', 
             'inventoryItems',
            'inventoryItems.product', 
            'inventoryItems.productColor', 
            'inventoryItems.productSize', 
            'inventoryItems.brand'
        )->findOrFail($id);
        return view('inventory-transfer.show', compact('inventoryTransfer'));
    }
}
