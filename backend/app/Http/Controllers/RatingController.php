<?php

namespace App\Http\Controllers;

use App\Events\NotificationSent;
use App\Models\Notification;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $userId=Auth::id();

        try {
            $validatedData = $request->validate([
                'trainer_id' => 'required|integer|exists:users,id',
                'rating' => 'nullable|numeric|min:1|max:5',
                'comment' => 'nullable|string',
                'feedback' => 'nullable|string',
            ]);
            $rating = Rating::create([
                'user_id' => $userId,
                'trainer_id' => $validatedData['trainer_id'],
                'rating' => $validatedData['rating'] ?? null,
                'feedback' => $validatedData['feedback'] ?? null,
                'comment' => $validatedData['comment'] ?? null
            ]);

            $userNotification =  Notification::create([
                'user_id' => $validatedData['trainer_id'], // المدرب الذي تم تقييمه
                'message' => 'You have received a new rating.', // الرسالة التي سيتم إرسالها
                'type' => 'rating', // نوع الإشعار
                'is_active' => 1, // الإشعار مفعل
            ]);
         broadcast(new NotificationSent($userNotification));

      

            return response()->json([
                'rating' => $rating,
                'message' => 'the rating created successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'an error occured',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getRatingByTrainerId($trainerId)
    {
        try {
            $rating = Rating::where('trainer_id', $trainerId)->get();
            if (!$rating) {
                return response()->json(['message' => "No ratings found for this trainer"], 404);
            }
            return response()->json([
                'rating' => $rating,
                'message' => "Ratings fetched successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'an error occured',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getAvgRatingByTrainerId($trainerId)
    {
        try {
            // حساب متوسط التقييم للمدرب المحدد
            $averageRating = Rating::where('trainer_id', $trainerId)->avg('rating');
    
            // إذا لم يكن هناك تقييمات، إرجاع رسالة مناسبة
            if (is_null($averageRating)) {
                return response()->json(['message' => "No ratings found for this trainer"], 404);
            }
    
            return response()->json([
                'trainer_id' => $trainerId,
                'average_rating' => round($averageRating, 2), // تقريب إلى رقمين عشريين
                'message' => "Average rating fetched successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    










    public function destroy($ratingId)
    {
        try {
            $rating = Rating::find($ratingId);

            if (!$rating) {
                return response()->json([
                    'message' => 'Rating not found'
                ], 404);
            }

            $rating->delete();

            return response()->json([
                'message' => 'Rating deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $ratingId)
    {
        $userId = Auth::id();
    
        try {
            $rating = Rating::findOrFail($ratingId);
    
            if ($rating->user_id !== $userId ) {
                return response()->json([
                    'error' => 'You are not authorized to update this rating.',
                ], 403);
            }
    
            $validatedData = $request->validate([
                'rating' => 'nullable|numeric|min:1|max:5',
                'comment' => 'nullable|string',
                'feedback' => 'nullable|string',
            ]);
    
            $rating->update([
                'rating' => $validatedData['rating'] ?? $rating->rating,
                'feedback' => $validatedData['feedback'] ?? $rating->feedback,
                'comment' => $validatedData['comment'] ?? $rating->comment,
            ]);
    
            $userNotification = Notification::create([
                'user_id' => $rating->trainer_id, // المدرب الذي تم تحديث تقييمه
                'message' => 'Your rating has been updated.', // الرسالة
                'type' => 'rating', // نوع الإشعار
                'is_active' => 1, // الإشعار مفعل
            ]);
    
            broadcast(new NotificationSent($userNotification));
    
            return response()->json([
                'rating' => $rating,
                'message' => 'The rating updated successfully.'
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    
}











      // $userNotification = Notification::create([
            //     'user_id' => Auth::id(),
            //     'register_id' => Auth::id(),
            //     'conference_id' => $conference_id,
            //     'message' => 'This process takes approximately one month from the date of application, and you will be notified of any updates regarding the visa status.',
            //     'is_read' => false,
            // ]);
            // broadcast(new NotificationSent($userNotification));













// $admins = User::where('isAdmin', true)->get();
// $userName = Auth::user()->name; // الحصول على اسم المستخدم

// foreach ($admins as $admin) {
//     // إنشاء الإشعار مع conference_id و title
//     $notification = Notification::create([
//         'user_id' => $admin->id,
//         'conference_id' => $conference_id,
//         'message' => 'New visa request from user: ' . $userName . ' for conference: ' . $conferenceTitle, // إضافة title في الرسالة
//         'is_read' => false,
//         'register_id' => Auth::id(),
//     ]);

//     // بث الإشعار
//     broadcast(new NotificationSent($notification))->toOthers();
// }