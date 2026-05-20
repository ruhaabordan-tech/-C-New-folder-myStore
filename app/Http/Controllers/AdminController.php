<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{

 public function index(){
$task=Admin::first();
 return response()->json($task,200);
 }

 public function store(StoreTaskRequest $request)
 {
    $task=Admin::create($request->validated());
        return response()->json([
            'message' => 'Admin created successfully',
            'data' => $task
        ], 201);
 }


  public function update(UpdateTaskRequest $request,string $id)
 {
    $task=Admin::findOrFail($id);
    $task->update($request->validated());
   return response()->json([
   'message' => 'Admin updated successfully', 
   'data'=> $task]
   ,200);
 }

 

  public function destroy(Request $request,string $id)
 {
    $task=Admin::findOrFail($id);
    $task->delete( );
   return response()->json([
    'message' => 'Admin deleted successfully', 
    ],204);
 }

}
