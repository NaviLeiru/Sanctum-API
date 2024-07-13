<?php

use App\Http\Controllers\Api\PostController; 
use App\Http\Controllers\Api\CommentController; 
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route; 



Route::middleware('auth:sanctum')->group(function () { 


Route::apiResource('posts', PostController::class); 

Route::post('posts',[PostController::class, 'store']);
Route::get('showpost', [PostController::class, 'show']);
Route::put('posts/{posts}', [PostController::class, 'update']);
Route::delete('posts/delete/{posts}', [PostController::class, 'destroy']);


Route::post('comments', [CommentController::class, 'store']);
Route::put('comments/{comment}', [CommentController::class, 'update']); 
Route::delete('comments/{comment}', [CommentController::class, 'destroy']); 


}); 