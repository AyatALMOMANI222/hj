<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::id();
        try {
            $validatedData = $request->validate([
                'trainer_id' => 'required',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i:s',
                'day' => 'required|string',
                'starting_location' => 'required|string|max:255',
                'status' => 'nullable|in:pending,confirmed,canceled,completed,postponed',
                'payment_status' => 'nullable|in:pending,paid,failed',
                'rating' => 'nullable|integer|min:1|max:5',
                'feedback' => 'nullable|string',
                'notes' => 'nullable|string',
                'trainer_notes' => 'nullable|string',
                'is_reminded' => 'nullable|boolean',
            ]);

            $booking = Booking::create([
                'driving_lessons_id' => $validatedData['driving_lessons_id'] ?? null,
                'trainee_id' => $userId,
                'trainer_id' => $validatedData['trainer_id'],
                'date' => $validatedData['date'],
                'time' => $validatedData['time'],
                'day' => $validatedData['day'],
                'starting_location' => $validatedData['starting_location'],
                'status' => $validatedData['status'] ?? "pending",
                'payment_status' => $validatedData['payment_status'] ?? "pending",
                'rating' => $validatedData['rating'] ?? null,
                'feedback' => $validatedData['feedback'] ?? null,
                'notes' => $validatedData['notes'] ?? null,
                'trainer_notes' => $validatedData['trainer_notes'] ?? null,
                'is_reminded' => $validatedData['is_reminded'] ?? false,
            ]);

            return response()->json([
                'message' => 'The Booking created Successfully',
                'Booking' => $booking
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدثت مشكلة أثناء إنشاء الحجز',
                'message' => $e->getMessage()
            ], 500);
        }
    }





    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        try {
            $validatedData = $request->validate([

                'status' => 'required|in:pending,confirmed,canceled,completed,postponed',
                'payment_status' => 'required|in:pending,paid,failed',
                'rating' => 'nullable|integer|min:1|max:5',
                'feedback' => 'nullable|string',
                'notes' => 'nullable|string',
                'trainer_notes' => 'nullable|string',
                'is_reminded' => 'nullable|boolean',
            ]);

            $userId = Auth::id();
            $userRole = Auth::user()->role;

            if ($userRole === 'admin') {
                $booking = Booking::where('id', $id)->first();
            } else {
                $booking = Booking::where('id', $id)->where('trainee_id', $userId)->first();
            }

            if (!$booking) {
                return response()->json([
                    'error' => 'The Booking does not exist',
                ], 404);
            }

            $booking->update([

                'status' => $validatedData['status'],
                'payment_status' => $validatedData['payment_status'],
                'rating' => $validatedData['rating'] ?? $booking->rating,
                'feedback' => $validatedData['feedback'] ?? $booking->feedback,
                'notes' => $validatedData['notes'] ?? $booking->notes,
                'trainer_notes' => $validatedData['trainer_notes'] ?? $booking->trainer_notes,
                'is_reminded' => $validatedData['is_reminded'] ?? $booking->is_reminded,
            ]);

            return response()->json([
                'message' => 'The Booking updated Successfully',
                'Booking' => $booking
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث مشكلة اثناء تحديث الحجز',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function deleteBooking($id)
    {
        try {
            $userId = Auth::id();
            $userRole = Auth::user()->role;

            if ($userRole === 'admin') {
                $booking = Booking::where('id', $id)->first();
            } else {
                $booking = Booking::where('id', $id)->where('trainee_id', $userId)->first();
            }

            if (!$booking) {
                return response()->json([
                    'error' => 'الحجز غير موجود أو ليس لديك الصلاحية لحذفه'
                ], 403);
            }

            $booking->delete();

            return response()->json([
                'message' => 'تم حذف الحجز بنجاح'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء حذف الحجز',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getBookings(Request $request)
    {
        try {
            $userId = Auth::id();
            $userRole = Auth::user()->role;

            $query = Booking::query();
            if ($userRole !== 'admin') {
                $query->where('trainee_id', $userId);
            }

            if ($request->has('driving_lessons_id')) {
                $query->where('driving_lessons_id', $request->driving_lessons_id);
            }
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
            if ($request->has('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }
            if ($request->has('trainee_id') && $userRole === 'admin') {
                $query->where('trainee_id', $request->trainee_id);
            }

            $bookings = $query->get();

            return response()->json([
                'message' => 'Bookings retrieved successfully',
                'bookings' => $bookings
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء جلب الحجوزات',
                'message' => $e->getMessage()
            ], 500);
        }
    }







    public function getPaidBookings(Request $request)
    {
        try {
            $userId = Auth::id();
            $userRole = Auth::user()->role;


            $query = Booking::with(['drivingLesson', 'trainee'])
                ->where('payment_status', 'paid');

            if ($userRole !== 'admin') {
                $query->where('trainee_id', $userId);
            }

            // // تطبيق الفلاتر الاختيارية
            // if ($request->has('driving_lessons_id')) {
            //     $query->where('driving_lessons_id', $request->driving_lessons_id);
            // }
            // if ($request->has('status')) {
            //     $query->where('status', $request->status);
            // }
            // if ($request->has('trainee_id') && $userRole === 'admin') {
            //     $query->where('trainee_id', $request->trainee_id);
            // }

            $paidBookings = $query->get();

            return response()->json([
                'message' => 'Paid bookings retrieved successfully',
                'paid_bookings' => $paidBookings
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء جلب الحجوزات المدفوعة',
                'message' => $e->getMessage()
            ], 500);
        }
    }




    public function sendNotificationBeforeLesson()
    {
        try {
            // استرجاع المستخدم (المتدرب أو المدرب) الحالي
            $userId = Auth::id();

            // استعلام للحصول على الجلسات التي تبدأ بعد 24 ساعة
            $bookings = Booking::where('trainee_id', $userId) // قد تحتاج لتغيير هذا إذا كان المدرب هو من يتم إعلامه أيضًا
                ->where('status', 'confirmed')
                ->whereHas('drivingLesson', function ($query) {
                    $query->where('start_time', '>=', Carbon::now())
                        ->where('start_time', '<', Carbon::now()->addHours(24)); // الجلسات القادمة في الـ 24 ساعة القادمة
                })
                ->get();

            // إرسال إشعار لكل حجز
            foreach ($bookings as $booking) {
                $lesson = $booking->drivingLesson;
                $user = $lesson->trainee; // يمكن أن تكون المتدرب أو المدرب حسب الحاجة

                // نص الإشعار
                $message = "تذكير: لديك جلسة تدريبية قريبًا , تبدأ في {$lesson->start_time}.";

                // إرسال الإشعار
                Notification::create([
                    'user_id' => $user->id,
                    'message' => $message,
                    'type' => 'lesson_reminder',
                    'read_status' => 'unread',
                    'is_active' => true
                ]);
            }

            return response()->json([
                'message' => 'تم إرسال الإشعارات بنجاح'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء إرسال الإشعارات',
                'message' => $e->getMessage()
            ], 500);
        }
    }

   
    public function getTrainerAvailableSessions($trainer_id, $date)
    {
        // جلب بيانات المدرب
        $trainer = User::where('id', $trainer_id)
            ->first(['available_from', 'available_to', 'break_time_duration', 'lesson_duration', 'available_days']);
    
        if (!$trainer) {
            return response()->json(['error' => 'المدرب غير موجود'], 404);
        }
    
        // تحويل القيم إلى أرقام صحيحة
        $startHour = intval($trainer->available_from);
        $endHour = intval($trainer->available_to);
        $sessionTime = intval($trainer->lesson_duration);
        $breakTime = intval($trainer->break_time_duration);
        $availableDays = explode(',', $trainer->available_days);
    
        // جلب الحجوزات في التاريخ المحدد
        $bookings = Booking::where('trainer_id', $trainer_id)
            ->whereDate('date', $date)
            ->get(['date', 'time']);
    
        // تجهيز البيانات للإرسال
        return response()->json([
            'trainer_data' => [
                'startHour' => $startHour,
                'endHour' => $endHour,
                'sessionTime' => $sessionTime,
                'breakTime' => $breakTime,
                'availableDays' => $availableDays,
            ],
            'bookings' => $bookings->map(fn($b) => [
                'date' => $b->date,
                'startTime' => $b->time,
                'endTime' => date("H:i:s", strtotime($b->time) + ($sessionTime * 60)), // حساب وقت النهاية
            ])
        ]);
    }
    
    
}
