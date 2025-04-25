<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavouriteController extends Controller
{
    public function addToFavourites(Request $request)
    {
        DB::select('CALL add_to_favourites(?, ?)', [
            $request->user_id,
            $request->item_id
        ]);
        return response()->json(['message' => 'Added to favourites']);
    }

    public function getUserFavourites($userId)
    {
        try {
            $favourites = DB::select('CALL get_user_favourites(?)', [$userId]);

            return response()->json([
                'status' => true,
                'data' => $favourites
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching favourites.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function deleteFavourite(Request $request)
    {
        DB::select('CALL delete_favourite(?, ?)', [
            $request->user_id,
            $request->item_id
        ]);
        return response()->json(['message' => 'Deleted from favourites']);
    }
}

