<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\RatingResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingResponseController extends Controller
{

    public function store(Request $request, $rating_id)
    {
        try {
            $validatedData = $request->validate([
                'response' => 'required|string',
                'type' => 'nullable|in:inquiry,general',
            ]);
    
            if (!Rating::where('id', $rating_id)->exists()) {
                return response()->json([
                    'message' => 'التقييم غير موجود.'
                ], 404);
            }
    
            $ratingResponse = RatingResponse::create([
                'rating_id' => $rating_id,
                'responder_id' => Auth::id(),
                'response' => $validatedData['response'],
                'type' => $validatedData['type'] ?? 'general',
            ]);
    
            return response()->json([
                'message' => 'تم إضافة الرد بنجاح.',
                'rating_response' => $ratingResponse
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'فشل التحقق من صحة البيانات.',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء إضافة الرد. حاول مرة أخرى.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function updateResponse(Request $request, $response_id)
    {
        try {
            $validatedData = $request->validate([
                'response' => 'required|string',
            ]);
    
            $ratingResponse = RatingResponse::find($response_id);
    
            if (!$ratingResponse) {
                return response()->json([
                    'message' => 'الرد غير موجود.'
                ], 404);
            }
    
            $user = Auth::user();
    
            if ($user->role !== 'admin' && $ratingResponse->responder_id !== $user->id) {
                return response()->json([
                    'message' => 'ليس لديك الصلاحية لتعديل هذا الرد.'
                ], 403);
            }
    
            $ratingResponse->update([
                'response' => $validatedData['response'],
            ]);
    
            return response()->json([
                'message' => 'تم تحديث الرد بنجاح.',
                'rating_response' => $ratingResponse
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'فشل التحقق من صحة البيانات.',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء تحديث الرد. حاول مرة أخرى.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
 
    public function getResponsesByRating($ratingId)
    {
        try {
            if (!Rating::where('id', $ratingId)->exists()) {
                return response()->json([
                    'message' => 'التقييم غير موجود.'
                ], 404);
            }
    
            $responses = RatingResponse::where('rating_id', $ratingId)->get();
    
            return response()->json([
                'responses' => $responses
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء جلب الردود. حاول مرة أخرى.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
  
    public function getResponsesByUser()
    {
        try {
            $userId = Auth::id();
    
            if (!$userId || !User::where('id', $userId)->exists()) {
                return response()->json([
                    'message' => 'المستخدم غير موجود أو غير مصرح له.'
                ], 404);
            }
    
            $responses = RatingResponse::where('responder_id', $userId)->get();
    
            return response()->json([
                'responses' => $responses
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء جلب الردود. حاول مرة أخرى.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function deleteResponse($response_id)
{
    try {
        $ratingResponse = RatingResponse::find($response_id);

        if (!$ratingResponse) {
            return response()->json([
                'message' => 'الرد غير موجود.'
            ], 404);
        }

        $user = Auth::user();

        if ($user->role !== 'admin' && $ratingResponse->responder_id !== $user->id) {
            return response()->json([
                'message' => 'ليس لديك الصلاحية لحذف هذا الرد.'
            ], 403);
        }

        $ratingResponse->delete();

        return response()->json([
            'message' => 'تم حذف الرد بنجاح.'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'حدث خطأ أثناء حذف الرد. حاول مرة أخرى.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
