<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{


public function getAllNotificationByUserId(Request $request)
{
    try {
        // استخراج user_id من التوكن
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // جلب الإشعارات الخاصة بالمستخدم
        $notifications = \App\Models\Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['notifications' => $notifications], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
    }
}

}
