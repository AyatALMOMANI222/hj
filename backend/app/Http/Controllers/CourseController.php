<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{


    // 'instructor_id',
    // 'center_id'
    public function store(Request $request)
    {

        try {
            $userId = Auth::id();

            $validatedData = $request->validate([
                'instructor_id' => 'nullable|exists:users,id',
                'name' => 'required|string',
                'description' => 'string|nullable',
                'duration' => 'required|numeric|min:0',
                'start_date' => 'required|date_format:Y-m-d H:i:s',
                'end_date' => 'nullable|date_format:Y-m-d H:i:s',
                'price' => 'required|numeric|min:0',
                'external_instructor_name' => 'string|nullable',
                'external_instructor_email' => 'string|nullable',
                'external_instructor_phone' => 'string|nullable',
                'external_instructor_language' => 'string|nullable'

            ]);

            $course = Course::create([
                'center_id' => $userId,
                'instructor_id' => $validatedData['instructor_id'] ?? null,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'duration' => $validatedData['duration'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'] ?? null,
                'price' => $validatedData['price'],
                'external_instructor_name' => $validatedData['external_instructor_name'] ?? null,
                'external_instructor_email' => $validatedData['external_instructor_email'] ?? null,
                'external_instructor_phone' => $validatedData['external_instructor_phone'] ?? null,
                'external_instructor_language' => $validatedData['external_instructor_language'] ?? null
            ]);

            return response()->json([
                'course' => $course,
                'message' => 'course created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'an error occured',
                'message' => $e->getMessage()
            ], 500);
        };
    }
    public function update(Request $request, $id)
    {
        try {
            $course = Course::find($id);

            if (!$course) {
                return response()->json([
                    'message' => 'لم يتم العثور على الدورة المطلوبة'
                ], 404);
            }
            if (Auth::user()->id !== $course->center_id && Auth::user()->role !== 'admin') {
                return response()->json([
                    'message' => 'ليس لديك الصلاحية لتعديل هذه الدورة'
                ], 403);
            }

            $validatedData = $request->validate([
                'center_id' => 'exists:users,id',
                'instructor_id' => 'nullable|exists:users,id',
                'name' => 'string',
                'description' => 'string|nullable',
                'duration' => 'numeric|min:0',
                'start_date' => 'date_format:Y-m-d H:i:s',
                'end_date' => 'nullable|date_format:Y-m-d H:i:s',
                'price' => 'numeric|min:0',
                'external_instructor_name' => 'string|nullable',
                'external_instructor_email' => 'string|nullable',
                'external_instructor_phone' => 'string|nullable',
                'external_instructor_language' => 'string|nullable'
            ]);

            $course->update([
                'center_id' => $request->has('center_id') ? $validatedData['center_id'] : $course->center_id,
                'instructor_id' => $request->has('instructor_id') ? $validatedData['instructor_id'] : $course->instructor_id,
                'name' => $request->has('name') ? $validatedData['name'] : $course->name,
                'description' => $request->has('description') ? $validatedData['description'] : $course->description,
                'duration' => $request->has('duration') ? $validatedData['duration'] : $course->duration,
                'start_date' => $request->has('start_date') ? $validatedData['start_date'] : $course->start_date,
                'end_date' => $request->has('end_date') ? $validatedData['end_date'] : $course->end_date,
                'price' => $request->has('price') ? $validatedData['price'] : $course->price,
                'external_instructor_name' => $request->has('external_instructor_name') ? $validatedData['external_instructor_name'] : $course->external_instructor_name,
                'external_instructor_email' => $request->has('external_instructor_email') ? $validatedData['external_instructor_email'] : $course->external_instructor_email,
                'external_instructor_phone' => $request->has('external_instructor_phone') ? $validatedData['external_instructor_phone'] : $course->external_instructor_phone,
                'external_instructor_language' => $request->has('external_instructor_language') ? $validatedData['external_instructor_language'] : $course->external_instructor_language
            ]);

            return response()->json([
                'course' => $course,
                'message' => 'تم تحديث الدورة بنجاح'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء تحديث الدورة',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getAllCources($center_id)
    {
        try {

            $cources = Course::where('center_id', $center_id)->get();

            return response()->json([
                'message' => 'تم جلب الكورسات بنجاح ',
                'courses' => $cources,



            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ أثناء جلب البيانات',
                'message' => $e->getMessage()

            ], 500);
        }
    }

    public function getAll()
    {
        try {
            $courses = Course::all();
            return response()->json([
                'message' => 'تم جلب البيانات بنجاح',
                'courses' => $courses
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ اثناء جلب البيانات',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()

            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $course = Course::find($id);

            if (!$course) {
                return response()->json([
                    'message' => 'لم يتم العثور على الدورة المطلوبة'
                ], 200);
            }
            $user = Auth::user();

            if ($user->role !== 'admin' && $user->id !== $course->center_id) {
                return response()->json([
                    'error' => 'ليس لديك الصلاحية لحذف هذه الدورة'
                ], 403);
            }
            $course->delete();
            return response()->json([
                'message' => 'تم حذف الدورة بنجاح'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حذث خطأ اثناء حذف الدورة',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
