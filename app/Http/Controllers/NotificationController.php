<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function addNotification(Request $request)
{
    $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'title' => 'required|string',
        'message' => 'required|string',
    ]);

    try {
        DB::statement('CALL add_notification(?, ?, ?)', [
            $request->user_id,
            $request->title,
            $request->message
        ]);

        return response()->json(['message' => 'Notification added successfully'], 201);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to add notification',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
