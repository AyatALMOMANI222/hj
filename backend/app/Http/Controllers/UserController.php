<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            // تحقق البيانات
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'phone' => 'nullable|string|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'is_admin' => 'sometimes|in:true,false',
                'role' => 'required|in:trainee,instructor,training_center,admin',
                'language' => 'nullable|string|max:255',
                'years_of_experience' => 'nullable|integer',
                'training_type' => 'nullable|in:beginner,advanced,highway_driving,city_driving',
                'car_type' => 'nullable|string|max:255',
                'rating' => 'nullable|integer|min:1|max:5',
                'license_type' => 'nullable|in:private,motorcycle,truck',
                'age' => 'nullable|integer|min:18|max:100',
                'session_duration' => 'nullable|string|max:255',
                'session_price' => 'nullable|numeric',
                'session_time' => 'nullable|in:morning,afternoon,evening',
                'field_training_available' => 'nullable|boolean',
                'test_preparation' => 'nullable|string|max:255',
                'special_training_programs' => 'nullable|in:women,elderly,special_needs',
                'is_active' => 'nullable|boolean',
                'profile_picture' => 'nullable',
                'center_location'  => 'nullable',
                'center_name' => 'nullable'
            ]);

            // تحديد قيمة is_admin بناءً على إذا تم إرسالها في الـ request
            $validatedData['is_admin'] = $request->has('is_admin') ? true : false;
            $imagePath = null;
            if ($request->hasFile('profile_picture')) {
                $imagePath = $request->file('profile_picture')->store('images', 'public');
            }


            // إضافة الحقول الجديدة إلى عملية إنشاء المستخدم
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'phone' => $validatedData['phone'],
                'whatsapp' => $validatedData['whatsapp'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'location' => $validatedData['location'] ?? null,
                'is_admin' => $validatedData['is_admin'],
                'role' => $validatedData['role'],
                // إضافة الحقول الجديدة هنا
                'language' => $validatedData['language'] ?? null,
                'years_of_experience' => $validatedData['years_of_experience'] ?? null,
                'training_type' => $validatedData['training_type'] ?? null,
                'car_type' => $validatedData['car_type'] ?? null,
                'rating' => $validatedData['rating'] ?? null,
                'license_type' => $validatedData['license_type'] ?? null,
                'age' => $validatedData['age'] ?? null,
                'session_duration' => $validatedData['session_duration'] ?? null,
                'session_price' => $validatedData['session_price'] ?? null,
                'session_time' => $validatedData['session_time'] ?? null,
                'field_training_available' => $validatedData['field_training_available'] ?? false,
                'test_preparation' => $validatedData['test_preparation'] ?? null,
                'special_training_programs' => $validatedData['special_training_programs'] ?? null,
                'is_active' => $validatedData['is_active'] ?? true,
                'profile_picture' => $imagePath, // إضافة صورة البروفايل
                'center_location' => $validatedData['center_location'] ?? null,
                'center_name' => $validatedData['center_name'] ?? null
            ]);

            // إرسال إشعار التحقق بالبريد الإلكتروني
            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully. Please check your email and verify your account by clicking the verification link.',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $user = User::findOrFail($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $id,
                'phone' => 'nullable|string|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'is_admin' => 'sometimes|in:true,false',
                'role' => 'nullable|in:trainee,instructor,training_center,admin',
                'language' => 'nullable|string|max:255',
                'years_of_experience' => 'nullable|integer',
                'training_type' => 'nullable|in:beginner,advanced,highway_driving,city_driving',
                'car_type' => 'nullable|string|max:255',
                'rating' => 'nullable|integer|min:1|max:5',
                'license_type' => 'nullable|in:private,motorcycle,truck',
                'age' => 'nullable|integer|min:18|max:100',
                'session_duration' => 'nullable|string|max:255',
                'session_price' => 'nullable|numeric',
                'session_time' => 'nullable|in:morning,afternoon,evening',
                'field_training_available' => 'nullable|boolean',
                'test_preparation' => 'nullable|string|max:255',
                'special_training_programs' => 'nullable|in:women,elderly,special_needs',
                'is_active' => 'nullable|boolean',
                'profile_picture' => 'nullable|image',
                'center_location'  => 'nullable',
                'center_name' => 'nullable'
            ]);

            if ($request->hasFile('profile_picture')) {
                $validatedData['profile_picture'] = $request->file('profile_picture')->store('images', 'public');
            }
            $user->update($validatedData);

            return response()->json([
                'message' => 'تم التحديث بنجاح',

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ اثناء التحديث',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getUsers(Request $request)
    {
        try {
            // تحقق من وجود دور المستخدم المطلوب
            $query = User::where('role', 'instructor');

            // تطبيق الفلاتر بناءً على الطلبات
            if ($request->has('years_of_experience')) {
                $query->where('years_of_experience', '>=', $request->years_of_experience);
            }

            if ($request->has('training_type')) {
                $query->where('training_type', $request->training_type);
            }

            if ($request->has('car_type')) {
                $query->where('car_type', 'like', '%' . $request->car_type . '%');
            }

            if ($request->has('language')) {
                $query->where('language', 'like', '%' . $request->language . '%');
            }

            if ($request->has('rating')) {
                $query->where('rating', '>=', $request->rating);
            }

            if ($request->has('age')) {
                $query->where('age', '>=', $request->age);
            }

            if ($request->has('session_duration')) {
                $query->where('session_duration', $request->session_duration);
            }

            if ($request->has('session_price')) {
                $query->where('session_price', '<=', $request->session_price);
            }

            if ($request->has('session_time')) {
                $query->where('session_time', $request->session_time);
            }

            if ($request->has('field_training_available')) {
                $query->where('field_training_available', $request->field_training_available);
            }

            if ($request->has('test_preparation')) {
                $query->where('test_preparation', 'like', '%' . $request->test_preparation . '%');
            }

            if ($request->has('license_type')) {
                $query->where('license_type', $request->license_type);
            }

            if ($request->has('special_training_programs')) {
                $query->where('special_training_programs', 'like', '%' . $request->special_training_programs . '%');
            }

            if ($request->has('location')) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            // فلترة حسب المسافة إذا كان هناك موقع
            if ($request->has('distance') && $request->has('latitude') && $request->has('longitude')) {
                $latitude = $request->latitude;
                $longitude = $request->longitude;
                $distance = $request->distance;  // المسافة بالكيلومتر
                $query->whereRaw("ST_Distance_Sphere(point(longitude, latitude), point(?, ?)) <= ?", [$longitude, $latitude, $distance * 1000]);
            }

            // إرجاع المستخدمين المدربين مع الفلاتر
            $users = $query->get();

            return response()->json([
                'success' => true,
                'users' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getUserByType($role)
    {
        try {
            $user = User::where('role', $role)->get();

            return response()->json([
                'user' => $user,
                'message' => `the {$role} fetched successfully`,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'an error occured',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {

        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'message' => 'المستخدم غير موجود'
                ], 200);
            }
            $user->delete();
            return response()->json([
                'message' => 'تم الحذف بنجاح',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدثت مشكلة اثناء الحذف',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getUserById($id)
    {
        try {
            $user = User::find($id);
    
            if (!$user) {
                return response()->json([
                    'message' => 'المستخدم غير موجود'
                ], 404);
            }
    
            return response()->json([
                'message' => 'تم جلب بيانات المستخدم بنجاح',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدثت مشكلة أثناء جلب البيانات',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}
