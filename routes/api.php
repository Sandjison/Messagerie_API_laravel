<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\Url;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GroupController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::prefix("v1.0.0")->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('show_user', [UserController::class, 'showUser']);


    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('group', [GroupController::class, 'createGroup']);
        Route::delete('delete_group/{id}', [GroupController::class, 'deleteGroup']);
        Route::get('show_group', [GroupController::class, 'showGroup']);

        Route::post('member/{user_id}/{group_id}', [MemberController::class, 'addMember']);
        Route::delete('delete_member/{id}', [MemberController::class, 'deleteMember']);

        Route::post('guest/{id}', [GuestController::class, 'addGuest']);
        Route::delete('delete_guest/{id}', [GuestController::class, 'deleteGuest']);

        Route::post('file', [FileController::class, 'addFile']);
        Route::delete('delete_file/{id}', [FileController::class, 'deleteFile']);
        Route::get('show_file/{group_id}', [FileController::class, 'showFile']);

        Route::delete('delete_user/{id}', [UserController::class, 'deleteUser']);
        Route::patch('update_user/{id}', [UserController::class, 'updateUser']);

        Route::get('group/{group_id}/file', [GroupController::class, 'sendFile']);

    });
});



// Route::prefix('users')->group(function () {
//     // Mettre à jour un utilisateur
//     Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    
//     // Supprimer un utilisateur
//     Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
// });