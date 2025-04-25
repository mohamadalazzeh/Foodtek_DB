<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function getAllOffers()
    {
        $offers = DB::select('CALL get_all_offers()');
        return response()->json($offers);
    }

    public function updateOffer(Request $request, $id)
    {
        try {
            DB::statement('CALL update_offer(?, ?, ?, ?, ?, ?)', [
                $id,
                $request->name,
                $request->description,
                $request->discount_percentage,
                $request->start_date,
                $request->end_date,
            ]);

            return response()->json(['message' => 'Offer updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update offer', 'error' => $e->getMessage()], 500);
        }}

        public function deleteOffer($id)
        {
            try {
                DB::statement('CALL delete_offer(?)', [$id]);
                return response()->json(['message' => 'Offer deleted successfully']);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to delete offer', 'error' => $e->getMessage()], 500);
            }
        }
        

    public function createOffer(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'discount_percentage' => 'required|numeric|between:0,100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        try {
            DB::statement('CALL create_offer(?, ?, ?, ?, ?)', [
                $request->name,
                $request->description,
                $request->discount_percentage,
                $request->start_date,
                $request->end_date
            ]);

            return response()->json(['message' => 'Offer created successfully'], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create offer',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
