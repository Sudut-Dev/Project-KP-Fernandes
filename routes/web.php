<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\VroomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;

// Route halaman dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route halaman login
Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login-process');
Route::get('/activate/request/{id}', [AuthController::class, 'activateRequest'])->name('activate.request');

// Route halaman daftar sebagai peminjam
Route::get('/register', [AuthController::class, 'register'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->middleware('guest')->name('register-process');

// Route logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= Resource Route ====================

// Rooms
Route::middleware('rolecheck:1')->group(function () {
    Route::get('/room', [RoomController::class, 'index'])->name('room.index');
    Route::post('/room/store', [RoomController::class, 'store'])->name('room.store');
    Route::put('/room/update', [RoomController::class, 'update'])->name('room.update');
    Route::delete('/room/destroy/{id}', [RoomController::class, 'destroy'])->name('room.destroy');

    // Disable & Enable room
    Route::get('/room/enable/{id}', [RoomController::class, 'enable'])->name('room.enable');
    Route::put('/room/disable/{id}', [RoomController::class, 'disable'])->name('room.disable');

    // Disable & Enable user
    Route::get('/user/enable/{id}', [UserController::class, 'enable'])->name('user.enable');
    Route::put('/user/disable/{id}', [UserController::class, 'disable'])->name('user.disable');
});

// Vrooms
Route::middleware('rolecheck:1')->group(function () {
    Route::get('/vroom', [VroomController::class, 'index'])->name('vroom.index');
    Route::post('/vroom/store', [VroomController::class, 'store'])->name('vroom.store');
    Route::put('/vroom/update', [VroomController::class, 'update'])->name('vroom.update');
    Route::delete('/vroom/destroy/{id}', [VroomController::class, 'destroy'])->name('vroom.destroy');

    // Disable & Enable room
    Route::get('/vroom/enable/{id}', [VroomController::class, 'enable'])->name('vroom.enable');
    Route::put('/vroom/disable/{id}', [VroomController::class, 'disable'])->name('vroom.disable');

});

// Users
Route::middleware('rolecheck:1,2,3')->group(function () {
    Route::patch('/profile/edit', [UserController::class, 'profileEdit'])->name('profile.edit');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
});
Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
Route::resource('user', UserController::class)->middleware('rolecheck:1');
Route::resource('role', RoleController::class)->middleware('rolecheck:1');


// Schedules
Route::middleware('rolecheck:1,2,3')->group(
    function () {
        Route::get('/request', [ScheduleController::class, 'request'])->name('request');
        Route::post('/request', [ScheduleController::class, 'requestProcess'])->name('request.process');
        Route::get('/request/edit/{id}', [ScheduleController::class, 'requestEdit'])->name('request.edit');
        Route::patch('/request/update/{id}', [ScheduleController::class, 'requestUpdate'])->name('request.update');
        Route::delete('/schedule/cancel/{id}', [ScheduleController::class, 'scheduleCancel'])->name('schedule.cancel');
        Route::get('/schedule/finish/{id}', [ScheduleController::class, 'scheduleFinish'])->name('schedule.finish');

        // Notes
        Route::get('/note/upload/{id}', [NoteController::class, 'upload'])->name('note.upload');
        Route::post('/note/store', [NoteController::class, 'store'])->name('note.store');
        Route::get('/note/broadcast/{noteId}', [NoteController::class, 'broadcast'])->name('note.broadcast');
    }
);

// Hanya Admin & Petugas yang bisa approve/decline pengajuan
Route::middleware('rolecheck:1,2')->group(
    function () {
        Route::get('/schedule/search', [ScheduleController::class, 'search'])->name('schedule.search');
        Route::get('/links/search', [LinksController::class, 'search'])->name('links.search');
        Route::get('/schedule/approve/{id}', [ScheduleController::class, 'scheduleProses'])->name('schedule.approve');
        Route::post('/schedule/decline', [ScheduleController::class, 'scheduleDecline'])->name('schedule.decline');

        Route::get('/room', [RoomController::class, 'index'])->name('room.index');
        Route::post('/room/store', [RoomController::class, 'store'])->name('room.store');
        Route::put('/room/update', [RoomController::class, 'update'])->name('room.update');
        Route::delete('/room/destroy/{id}', [RoomController::class, 'destroy'])->name('room.destroy');

        // Disable & Enable room
        Route::get('/room/enable/{id}', [RoomController::class, 'enable'])->name('room.enable');
        Route::put('/room/disable/{id}', [RoomController::class, 'disable'])->name('room.disable');

        Route::get('/vroom', [VroomController::class, 'index'])->name('vroom.index');
        Route::post('/vroom/store', [VroomController::class, 'store'])->name('vroom.store');
        Route::put('/vroom/update', [VroomController::class, 'update'])->name('vroom.update');
        Route::delete('/vroom/destroy/{id}', [VroomController::class, 'destroy'])->name('vroom.destroy');

        // Disable & Enable room
        Route::get('/vroom/enable/{id}', [VroomController::class, 'enable'])->name('vroom.enable');
        Route::put('/vroom/disable/{id}', [VroomController::class, 'disable'])->name('vroom.disable');

    }
);


//Route links
Route::middleware('rolecheck:1,2')->group(function () {
    Route::get('/links', [LinksController::class, 'index'])->name('links.index');
    Route::post('/links/store', [LinksController::class, 'store'])->name('links.store');
    Route::post('/links/create', [LinksController::class, 'create'])->name('links.create');
    Route::put('/links/update', [LinksController::class, 'update'])->name('links.update');
});


Route::get('/change-month/{current}/{counter}', [ScheduleController::class, 'changeMonth'])->name('change-month');
Route::resource('schedule', ScheduleController::class)->middleware('rolecheck:1,2');
Route::resource('links', LinksController::class)->middleware('rolecheck:1,2');