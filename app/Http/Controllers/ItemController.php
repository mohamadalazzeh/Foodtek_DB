<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
  
    public function getAllItems()
    {
        $items = Item::all();  // استرجاع كل العناصر من الجدول
        return response()->json($items);
    }

    public function createItem(Request $request)
    {
        try {
            DB::statement('CALL create_item(?, ?, ?, ?, ?)', [
                $request->name,
                $request->order_id,
                $request->quantity,
                $request->price,
                $request->image
            ]);
    
            return response()->json(['message' => 'Item created successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create item',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateItem(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $request->validate([
            'name' => 'nullable|string',
            'order_id' => 'nullable|exists:orders,id',
            'quantity' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'image' => 'nullable|string',
        ]);

        $item->update([
            'name' => $request->name ?? $item->name,
            'order_id' => $request->order_id ?? $item->order_id,
            'quantity' => $request->quantity ?? $item->quantity,
            'price' => $request->price ?? $item->price,
            'image' => $request->image ?? $item->image,
        ]);

        return response()->json([
            'message' => 'Item updated successfully',
            'item' => $item
        ]);
    }
    public function deleteItem($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
}
    

