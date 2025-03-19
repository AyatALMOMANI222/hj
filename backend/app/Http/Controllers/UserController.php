<?php

namespace App\Http\Controllers;

use App\Events\NotificationSent;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
                'address' => 'nullable|max:255',
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
                'center_name' => 'nullable',
                'available_from' => 'nullable',
                'available_to' => 'nullable',
                'break_time_duration' => 'nullable|integer',
                'lesson_duration' => 'nullable|integer',
                'available_days' => 'nullable|string|max:255',
            ]);

            // تحديد قيمة is_admin بناءً على إذا تم إرسالها في الـ request
            $validatedData['is_admin'] = $request->has('is_admin') ? true : false;
            $imagePath = null;
            if ($request->hasFile('profile_picture')) {
                $imagePath = $request->file('profile_picture')->store('images', 'public');
            }
            
            // If available_days is empty or null, add a test value to see if it can be saved
            if (empty($validatedData['available_days'])) {
                Log::info('Setting test value for available_days');
                $validatedData['available_days'] = 'test_sunday,test_monday';
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
                'center_name' => $validatedData['center_name'] ?? null,
                'available_from' => $validatedData['available_from'] ?? null,
                'available_to' => $validatedData['available_to'] ?? null,
                'break_time_duration' => $validatedData['break_time_duration'] ?? null,
                'lesson_duration' => $validatedData['lesson_duration'] ?? null,
                'available_days' => $validatedData['available_days'] ?? null,
            ]);

            // إرسال إشعار التحقق بالبريد الإلكتروني
            $user->sendEmailVerificationNotification();
            $role = $user->role;
            $admins = User::whereIn('role', ['admin', 'instructor'])->get();

            foreach ($admins as $admin) {
                // إنشاء الإشعار
                // تعديل الرسالة بناءً على نوع التسجيل


                // إنشاء الإشعار مع الرسالة المناسبة
                $notification = Notification::create([
                    'user_id' => $admin->id,
                    'register_id' => $user->id,
                    'read_status' => 'unread', // يجب أن يكون مطابقاً لجدول الإشعارات
                    'message' => 'New ' . $role . ' registration: ' . $user->name,  // استخدم النوع في الرسالة
                    'is_read' => false,
                    'type' => $role
                ]);


                // بث الإشعار
                broadcast(new NotificationSent($notification))->toOthers();
            }


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
            // Find the user or return a 404 error
            $user = User::findOrFail($id);

            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $id,
                'phone' => 'nullable|string|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'address' => 'nullable|max:255',
                'location' => 'nullable|string|max:255',
                'is_admin' => 'sometimes|in:true,false',
                'role' => 'nullable|in:trainee,instructor,training_center,admin',
                'language' => 'nullable|string|max:255',
                'years_of_experience' => 'nullable|integer',
                'training_type' => 'nullable|in:beginner,advanced,highway_driving,city_driving',
                'car_type' => 'nullable|string|max:255',
                'rating' => 'nullable|integer|min:1|max:5',
                'license_type' => 'nullable|in:private,motorcycle,truck,general',
                'age' => 'nullable|integer|min:18|max:100',
                'session_duration' => 'nullable|string|max:255',
                'session_price' => 'nullable|numeric',
                'session_time' => 'nullable|in:morning,afternoon,evening',
                'field_training_available' => 'nullable|boolean',
                'test_preparation' => 'nullable',
                'special_training_programs' => 'nullable',
                'is_active' => 'nullable|boolean',
                'profile_picture' => 'nullable|image|max:2048', // Limit file size to 2MB
                'center_location'  => 'nullable',
                'center_name' => 'nullable',
                'available_from' => 'nullable',
                'available_to' => 'nullable',
                'break_time_duration' => 'nullable|integer',
                'lesson_duration' => 'nullable|integer',
                'available_days' => 'nullable|string|max:255',
                'current_password' => 'nullable|string',
                'new_password' => 'nullable|string|min:8|confirmed',
                'new_password_confirmation' => 'nullable|string',
            ]);

            // Handle password update if provided
            if (isset($validatedData['current_password']) && isset($validatedData['new_password'])) {
                // Verify the current password
                if (!Hash::check($validatedData['current_password'], $user->password)) {
                    return response()->json([
                        'error' => 'كلمة المرور الحالية غير صحيحة',
                    ], 422);
                }
                
                // Update the password
                $validatedData['password'] = bcrypt($validatedData['new_password']);
                
                // Remove the password fields from validatedData
                unset($validatedData['current_password']);
                unset($validatedData['new_password']);
                unset($validatedData['new_password_confirmation']);
            }

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Store the new image
                $validatedData['profile_picture'] = $request->file('profile_picture')->store('images', 'public');
                
                // Delete the old image if it exists
                if ($user->profile_picture && !str_contains($user->profile_picture, 'http')) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
            } else {
                // Don't update the profile_picture field if no new file was uploaded
                unset($validatedData['profile_picture']);
            }
            if (isset($validatedData['special_training_programs']) && $validatedData['special_training_programs'] === $user->special_training_programs) {
                unset($validatedData['special_training_programs']);
            }
         foreach (['field_training_available', 'test_preparation', 'special_training_programs', 'is_active'] as $field) {
   
   
   
            if (isset($validatedData[$field])) {
        // إذا كان الحقل هو special_training_programs
  
     
        
        // إذا كان الحقل هو test_preparation
        if ($field == 'test_preparation') {
            // التأكد من أن القيمة هي إما 'on' أو 'off'
            $validatedData[$field] = ($validatedData[$field] == 'on') ? 'on' : 'off';
        }

        // إذا كان الحقل هو field_training_available أو is_active
        if (in_array($field, ['field_training_available', 'is_active'], true)) {
            // تحويل القيمة إلى 0 أو 1 بناءً على القيم البوليانية
            $validatedData[$field] = filter_var($validatedData[$field], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }
    }
}


            // Update the user
            $user->update($validatedData);

            return response()->json([
                'message' => 'تم تحديث البيانات بنجاح',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'خطأ في البيانات المدخلة',
                'message' => $e->errors()
            ], 422);
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
            if ($request->filled('years_of_experience')) {
                $range = explode(',', $request->years_of_experience); // تقسيم القيمة إلى نطاقين

                if (count($range) == 2) {
                    $query->whereBetween('years_of_experience', [(int)$range[0], (int)$range[1]]);
                }
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

            // if ($request->has('age')) {
            //     $query->where('age', '>=', $request->age);
            // }
            if ($request->filled('age')) {
                switch ($request->age) { // استخدم "age" بدلاً من "age_group"
                    case 'under_30':
                        $query->where('age', '<', 30);
                        break;
                    case 'between_30_40': // مطابق للقيمة الجديدة في القائمة
                        $query->whereBetween('age', [30, 40]);
                        break;
                    case 'over_40':
                        $query->where('age', '>', 40);
                        break;
                }
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
            // إذا كان الدور "all" يتم جلب جميع المستخدمين
            if ($role === 'all') {
                $users = User::all();
                $message = 'All users fetched successfully';
            } else {
                // إذا كان هناك دور محدد يتم جلب المستخدمين بناءً عليه
                $users = User::where('role', $role)->get();
                $message = "The {$role} fetched successfully";
            }

            return response()->json([
                'users' => $users,  // تم تغيير 'user' إلى 'users' لأننا قد نسترجع مجموعة من المستخدمين
                'message' => $message,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred',
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
            $user = User::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'تم جلب بيانات المستخدم بنجاح',
                'user' => $user
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'المستخدم غير موجود',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب البيانات',
                'error' => $e->getMessage()
            ], 500);
        }
    }








    public function getAuthenticatedUser()
    {
        try {
            // التأكد من أن المستخدم مسجل دخول
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'المستخدم غير مصرح له أو لم يتم تسجيل الدخول',
                ], 401);
            }

            // جلب بيانات المستخدم من التوكن
            $user = Auth::user();

            return response()->json([
                'success' => true,
                'message' => 'تم جلب بيانات المستخدم بنجاح',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء جلب البيانات',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
