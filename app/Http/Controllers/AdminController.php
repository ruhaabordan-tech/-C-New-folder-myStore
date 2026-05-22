<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreAdminRequest; 
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function index()
    {
        $admin = Admin::first();
        if (!$admin) {
            return response()->json(['message' => 'لا يوجد مسؤول مسجل حالياً'], 404);
        }
        return response()->json($admin, 200);
    }

    public function store(StoreAdminRequest $request)
    {
        $admin = Admin::create($request->validated());
        return response()->json([
            'message' => 'تم إنشاء حساب المسؤول بنجاح',
            'data' => $admin
        ], 201);
    }

    public function update(UpdateAdminRequest $request, string $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update($request->validated());
        
        return response()->json([
            'message' => 'تم تحديث بيانات المسؤول بنجاح', 
            'data'=> $admin
        ], 200);
    }

    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        
        return response()->json([
            'message' => 'تم حذف المسؤول بنجاح', 
        ], 200);
    }
}
