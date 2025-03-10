<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehiclesController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'type' => 'required|string',
                'model' => 'string',
                'status' => 'required|string',
                'location' => 'nullable|string',
                'year' => 'nullable|integer',
                'registration_number' => 'nullable|string',
                'color' => 'nullable|string',
                'seats' => 'nullable|integer',
                'chassis_number' => 'nullable|string',
                'fuel_type' => 'nullable|string',
                'mileage' => 'nullable|integer',
                'engine_capacity' => 'nullable|integer',
                'last_service_date' => 'nullable|date',
                'notes' => 'nullable|string',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imagePaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('vehicle', 'public');
                }
            }

            // إنشاء السجل في قاعدة البيانات مع مسارات الصور
            $vehicle = Vehicle::create([
                'user_id' => $validatedData['user_id'],
                'type' => $validatedData['type'],
                'model' => $validatedData['model'],
                'status' => $validatedData['status'],
                'location' => $validatedData['location'] ?? null,
                'year' => $validatedData['year'] ?? null,
                'registration_number' => $validatedData['registration_number'] ?? null,
                'color' => $validatedData['color'] ?? null,
                'seats' => $validatedData['seats'] ?? null,
                'chassis_number' => $validatedData['chassis_number'] ?? null,
                'fuel_type' => $validatedData['fuel_type'] ?? null,
                'mileage' => $validatedData['mileage'] ?? null,
                'engine_capacity' => $validatedData['engine_capacity'] ?? null,
                'last_service_date' => $validatedData['last_service_date'] ?? null,
                'notes' => $validatedData['notes'] ?? null,
                'images' => json_encode($imagePaths)
            ]);

            return response()->json([
                'message' => 'تم اضافة مركبة بنجاح',
                'vehicle' => $vehicle
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        // المصادقة
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $userRole = Auth::user()->role;
        $vehicle = Vehicle::find($id);
        $user = User::find($vehicle->user_id);

        if ($user->id !== $userId && $userRole  !== 'admin') {
            return response()->json([
                'message' => 'ليس لديك صلاحية لتعديل بيانات المركبة '
            ], 403);
        }
     
        try {
            $validatedData = $request->validate([
                'type' => 'nullable|string',
                'status' => 'nullable|string',
                'location' => 'nullable|string',
                'year' => 'nullable|integer',
                'registration_number' => 'nullable|string',
                'color' => 'nullable|string',
                'seats' => 'nullable|integer',
                'chassis_number' => 'nullable|string',
                'fuel_type' => 'nullable|string',
                'mileage' => 'nullable|integer',
                'engine_capacity' => 'nullable|integer',
                'last_service_date' => 'nullable|date',
                'notes' => 'nullable|string',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $vehicle = Vehicle::findOrFail($id);

            $imagePaths = [];

            if ($request->hasFile('images')) {
                $oldImages = json_decode($vehicle->images);
                if ($oldImages) {
                    foreach ($oldImages as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }

                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('vehicle', 'public');
                }
            } else {
                $imagePaths = json_decode($vehicle->images);
            }

            $vehicle->update([
                'type' => $request->has('type') ? $validatedData['type'] : $vehicle->type,
                'status' => $request->has('status') ? $validatedData['status'] : $vehicle->status,
                'location' => $request->has('location') ? $validatedData['location'] : $vehicle->location,
                'year' => $request->has('year') ? $validatedData['year'] : $vehicle->year,
                'registration_number' => $request->has('registration_number') ? $validatedData['registration_number'] : $vehicle->registration_number,
                'color' => $request->has('color') ? $validatedData['color'] : $vehicle->color,
                'seats' => $request->has('seats') ? $validatedData['seats'] : $vehicle->seats,
                'chassis_number' => $request->has('chassis_number') ? $validatedData['chassis_number'] : $vehicle->chassis_number,
                'fuel_type' => $request->has('fuel_type') ? $validatedData['fuel_type'] : $vehicle->fuel_type,
                'mileage' => $request->has('mileage') ? $validatedData['mileage'] : $vehicle->mileage,
                'engine_capacity' => $request->has('engine_capacity') ? $validatedData['engine_capacity'] : $vehicle->engine_capacity,
                'last_service_date' => $request->has('last_service_date') ? $validatedData['last_service_date'] : $vehicle->last_service_date,
                'notes' => $request->has('notes') ? $validatedData['notes'] : $vehicle->notes,
                'images' => json_encode($imagePaths),
            ]);

            return response()->json([
                'message' => 'تم تحديث المركبة بنجاح',
                'vehicle' => $vehicle
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getVehicleByOwner($userId)
    {
        try {
            $vehicles = Vehicle::where("user_id", $userId)->get();

            return response()->json([
                'message' => 'تم جلب المركبات بنجاح ',
                'vehicles' => $vehicles
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ ما اثناء جلب المركبات',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getVehiclesById($id)
    {
        try {
            $vehicles = Vehicle::find($id);
            return response()->json([
                'message' => 'تم جلب بيانات المركبة بنجاح',
                'vehicles' => $vehicles
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ ما اثناء جلب بيانات المركبة',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;
        try {
            $vehicle = Vehicle::find($id);
            if (!$vehicle) {
                return response()->json([
                    'message' => 'لا يوجد مركبة'
                ], 404);
            }
            if ($vehicle->user_id !== $userId  && $userRole !== "admin") {
                return response()->json([
                    'message' => 'ليس لديك صلاحيات لحذف هذه المركبة '
                ], 403);
            }

            if (!empty($vehicle->images)) {
                $imagePaths = json_decode($vehicle->images, true);
                foreach ($imagePaths as $path) {
                    Storage::disk('public')->delete($path);
                }
            }
            $vehicle->delete();
            return response()->json([
                'message' => 'تم حذف المركبة بنجاح'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ ما',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
