<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// auth
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);
Route::middleware('auth:api')->get("/users", [UserController::class, 'index']);
// user
// Route::get("/users", [UserController::class, 'index']);
Route::group( ['prefix' => 'user','middleware' => ['auth:api']],function(){
    Route::get("/me", [UserController::class, 'getProfile']);
    Route::post("/store", [UserController::class, 'store']);
    Route::put("/update/{id}", [UserController::class, 'update']);
    Route::delete("/delete/{id}", [UserController::class, 'delete']);
    Route::get("/mentor/{id}/courses",[CourseController::class,'listByMentor']);
    Route::get("/{id}/courses",[CourseController::class,'listByMember']);

});
Route::group( ['prefix' => 'course'],function(){
    Route::get("/list", [CourseController::class, 'list']);
    Route::post("/create", [CourseController::class, 'store']);
    Route::post("/update/{id}", [CourseController::class, 'update']);
    // Route::put("/update/{id}", [UserController::class, 'update']);
    Route::delete("/delete/{id}", [CourseController::class, 'delete']);
    // Route::get("/{id}/members",[UserController::class,'listByMentor']);
    Route::get("/{id}/members", [CourseController::class, 'listMember']);
    Route::get("/{id}", [CourseController::class, 'detail']);
    Route::post("/{id}/create", [LessonController::class, 'store']);
    
});
Route::group( ['prefix' => 'lesson','middleware' => ['auth:api']],function(){
    Route::get("/detail/{id}", [LessonController::class, 'detail']);
    Route::post("/create", [LessonController::class, 'store']);
    Route::post("/update/{id}", [LessonController::class, 'update']);
    Route::delete("/delete/{id}", [LessonController::class, 'delete']);

});
Route::group( ['prefix' => 'test','middleware' => ['auth:api']],function(){
    Route::post("/save_history", [TestController::class, 'insertHistory']);
    Route::get("/list", [TestController::class, 'list']);
    Route::post("/update/{id}", [TestController::class, 'update']);
    Route::delete("/delete/{id}", [TestController::class, 'delete']);
    Route::post("/create", [TestController::class, 'store']);
    Route::get("/{id}", [TestController::class, 'getDetail']);
    Route::post("/question/create", [TestController::class, 'storeQuestion']);
    Route::put("/question/update/{id}", [TestController::class, 'updateQuestion']);
    Route::delete("/question/delete/{id}", [TestController::class, 'deleteQuestion']);

});
Route::middleware('auth:api')->get("/chat/rooms", [ChatController::class, 'rooms']);
Route::middleware('auth:api')->get("/chat/room/{roomId}/messages", [ChatController::class, 'messages']);
Route::middleware('auth:api')->post("/chat/roomm/{roomId}/message", [ChatController::class, 'newMessage']);

Route::middleware('auth:api')->post("/document/create", [DocumentController::class, 'store']);
Route::get("/document/download", [DocumentController::class, 'downloadFile']);
Route::get("/document/lessons/{id}", [DocumentController::class, 'getVideo']);
