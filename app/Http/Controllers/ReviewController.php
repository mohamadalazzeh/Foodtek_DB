<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        try {
            DB::statement('CALL create_review(?, ?, ?, ?)', [
                $request->user_id,
                $request->item_id,
                $request->rating,
                $request->review
            ]);

            return response()->json(['message' => 'Review created successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create review', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateReview(Request $request, $id)
    {
        try {
            DB::statement('CALL update_review(?, ?, ?)', [
                $id,
                $request->rating,
                $request->review
            ]);

            return response()->json(['message' => 'Review updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update review', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteReview($id)
    {
        try {
            DB::statement('CALL delete_review(?)', [$id]);

            return response()->json(['message' => 'Review deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete review', 'error' => $e->getMessage()], 500);
        }
    }
}
