<?php

namespace App\Http\Controllers;

use App\Models\DrivingLesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;

class DrivingLessonController extends Controller
{
    public function store(Request $request)
    {
        try {
            $userId = Auth::id();
            $validatedData = $request->validate([
                'course_id' => 'nullable|exists:cources,id',
                'instructor_id' => 'required|exists:users,id',
                'center_id' => 'nullable|exists:users,id',
                'vehicle_id' => 'nullable|exists:vehicles,id',
                'title' => 'required|string',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'start_time' => 'required|date|after_or_equal:now',
                'end_time' => 'nullable|date|after:start_time',
                'location' => 'nullable|string|max:255',
                'status' => 'nullable|in:pending,scheduled,completed,canceled',
                'max_students' => 'nullable|integer|min:1',
                'visibility' => 'nullable|in:public,registered,invited',
                'duration' => 'nullable|integer',
                'training_type' => 'nullable|in:مبتدئين,متقدم,القيادة في الطرق السريعة,القيادة في المدن,القيادة الليلية,القيادة في الظروف الجوية السيئة,القيادة في المناطق الجبلية,القيادة الدفاعية,القيادة لذوي الاحتياجات الخاصة,قيادة السيارات ذات الجير اليدوي,قيادة السيارات ذات الجير الأوتوماتيكي',
                'created_by' => 'nullable|exists:users,id',
            ]);
            $lessons = DrivingLesson::create([
                'course_id' => $validatedData['course_id'] ?? null,
                'instructor_id' => $validatedData['instructor_id'],
                'center_id' => $validatedData['center_id'] ?? null,
                'vehicle_id' => $validatedData['vehicle_id'] ?? null,
                'title' => $validatedData['title'],
                'price' => $validatedData['price'],
                'description' => $validatedData['description'] ?? null,
                'start_time' => $validatedData['start_time'],
                'end_time' => $validatedData['end_time'] ?? null,
                'location' => $validatedData['location'] ?? null,
                'status' => $validatedData['status'] ?? 'pending',
                'max_students' => $validatedData['max_students'] ?? 0,
                'visibility' => $validatedData['visibility'] ?? 'registered',
                'duration' => $validatedData['duration'] ?? 0,
                'training_type' => $validatedData['training_type'] ?? null, 
                'created_by' => $userId
            ]);


            return response()->json([
                'message' => 'تم انشاء جلسة بنجاح',
                'lesson' => $lessons
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ ما اثناء انشاء جلسة',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // جلب الجلسة المطلوبة
            $lesson = DrivingLesson::findOrFail($id);

            // التحقق من صلاحية المستخدم (يمكنك تعديل هذا حسب حاجتك)
            if (Auth::id() !== $lesson->created_by && Auth::id() !== $lesson->instructor_id && Auth::user()->role !== 'admin') {
                return response()->json([
                    'error' => 'ليس لديك صلاحية لتعديل هذه الجلسة'
                ], 403);
            }

            // التحقق من البيانات المدخلة فقط
            $validatedData = $request->validate([
                'course_id' => 'nullable|exists:cources,id',
                'instructor_id' => 'nullable|exists:users,id',
                'center_id' => 'nullable|exists:users,id',
                'vehicle_id' => 'nullable|exists:vehicles,id',

                'title' => 'nullable|string',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'start_time' => 'nullable|date|after_or_equal:now',
                'end_time' => 'nullable|date|after:start_time',
                'location' => 'nullable|string|max:255',
                'status' => 'nullable|in:pending,scheduled,completed,canceled',
                'max_students' => 'nullable|integer|min:1',
                'duration' => 'nullable|integer',
                'visibility' => 'nullable|in:public,registered,invited',
                'training_type' => 'nullable|in:مبتدئين,متقدم,القيادة في الطرق السريعة,القيادة في المدن,القيادة الليلية,القيادة في الظروف الجوية السيئة,القيادة في المناطق الجبلية,القيادة الدفاعية,القيادة لذوي الاحتياجات الخاصة,قيادة السيارات ذات الجير اليدوي,قيادة السيارات ذات الجير الأوتوماتيكي',

            ]);

            foreach ($validatedData as $key => $value) {
                if ($value !== null) {
                    $lesson->$key = $value;
                }
            }

            // حفظ التعديلات
            $lesson->save();

            return response()->json([
                'message' => 'تم تحديث الجلسة بنجاح',
                'lesson' => $lesson
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء تحديث الجلسة',
                'message' => $e->getMessage()
            ], 500);
        }
    }




    public function getByType($id, $type)
    {
        try {
            $allowedTypes = ['course', 'instructor', 'center'];

            if (!in_array($type, $allowedTypes)) {
                return response()->json([
                    'error' => 'نوع البحث غير صالح'
                ], 400);
            }

            $column = $type . '_id';
            // dd($column);
            $lesson = DrivingLesson::where($column, $id)->get();



            return response()->json([
                'message' => 'تم جلب البيانات بنجاح',
                'lesson' => $lesson
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ اثناء جلب البيانات',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        $userId = Auth::user()->id;
        $role = Auth::user()->role;
        try {

            $lesson = DrivingLesson::findOrFail($id);
            if (!$lesson) {
                return response()->json([
                    'message' => 'الجلسة غير موجودة'
                ], 404);
            }

            if ($lesson->created_by !== $userId && $role !== 'admin') {
                return response()->json([
                    'message' => 'ليس لديك صلاحية لحذف هذه الجلسة'
                ], 403);
            }
            $lesson->delete();
            return response()->json([
                'message' => 'تم حذف الجلسة بنجاح',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ اثناء حذف الجلسة',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function getCompletedLessonsByInstructor($instructorId)
    {
        try {
            // حساب عدد الدروس المكتملة للمدرب المحدد
            $count = DrivingLesson::where('instructor_id', $instructorId)
                ->where('status', 'completed')
                ->count();
    
            return response()->json([
                'success'=>true,
                'instructor_id' => $instructorId,
                'completed_lessons_count' => $count
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء جلب عدد الدروس المكتملة',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    

    public function getDrivingLessonByInstructorId(Request $request)
    {
        try {
            // استرجاع المعرف من التوكن (المستخدم الحالي)
            $instructorId = Auth::id();
    
            // التحقق من وجود المدرب في قاعدة البيانات
            $instructor = User::find($instructorId);
            if (!$instructor) {
                return response()->json([
                    'error' => 'المدرب غير موجود'
                ], 404);
            }
    
            // استرجاع الجلسات الخاصة بالمدرب
            $lessons = DrivingLesson::where('instructor_id', $instructorId)
                                    ->get();
    
            // التحقق إذا كان هناك جلسات
            if ($lessons->isEmpty()) {
                return response()->json([
                    'message' => 'لا توجد جلسات لهذا المدرب'
                ], 404);
            }
    
            // إرجاع الجلسات
            return response()->json([
                'lessons' => $lessons
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ ما أثناء استرجاع الجلسات',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    






}
