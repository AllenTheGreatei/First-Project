<?php

use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserAjaxActionController;
use App\Http\Controllers\UserNavigationController;

use App\Http\Controllers\AdminNavigationController;
use App\Http\Controllers\AdminAjaxController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\VerifycationController;

Route::get('/', [UserNavigationController::class, 'index'])->name('home');

// Landing Page Route
// Route::get('/register', [RegisterController::class, 'index'])->name('register');
// Route::get('/register2', [RegisterController::class, 'register2'])->name('register2');

// Route::get('/login', [LoginBasic::class, 'index'])->name('login');

// USER
// Auth::routes([
//   'verify' => true,
// ]);
Route::get('email/verify/{id}/{hash}', [VerifycationController::class, 'verify'])->name('verification.verify');
Route::get('/rooms', [UserNavigationController::class, 'rooms'])->name('rooms');
Route::get('/home', [UserNavigationController::class, 'index'])->name('home');

Route::post('/register', [UserAjaxActionController::class, 'register'])->name('register');
// Route::post('/validate_otp', [UserAjaxActionController::class, 'validate_otp'])->name('validate_otp');
// Route::post('/sendOtp', [UserAjaxActionController::class, 'sendOtp'])->name('sendOtp');
Route::post('/google', [UserAjaxActionController::class, 'google_handler'])->name('google');
Route::post('/login_ajax', [UserAjaxActionController::class, 'login_ajax'])->name('login_ajax');
Route::post('/logout_ajax', [UserAjaxActionController::class, 'logout_ajax'])->name('logout_ajax');

// Route::get('/otp', [UserAuthController::class, 'otp'])->name('otp');
Route::get('/register', [UserAuthController::class, 'register'])->name('register');
// Route::get('/register2', [UserAuthController::class, 'register2'])->name('register2');
Route::get('/login', [UserAuthController::class, 'index'])->name('login');

// ADMIN
Route::post('/retrive_room', [AdminRoomController::class, 'retrive_room'])->name('retrive_room');
Route::post('/delete_room', [AdminRoomController::class, 'delete_room'])->name('delete_room');
Route::post('/addNewRoom', [AdminRoomController::class, 'addNewRoom'])->name('addNewRoom');
Route::post('/submit_edit_room', [AdminRoomController::class, 'submit_edit_room'])->name('submit_edit_room');

Route::post('/add_category', [AdminRoomController::class, 'add_category'])->name('add_category');
Route::post('/delete_category', [AdminRoomController::class, 'delete_category'])->name('delete_category');
Route::post('/show_category', [AdminRoomController::class, 'show_category'])->name('show_category');
Route::post('/save_edited_category', [AdminRoomController::class, 'save_edited_category'])->name(
  'save_edited_category'
);
Route::post('/add_facility', [AdminRoomController::class, 'add_facility'])->name('add_facility');
Route::post('/delete_facility', [AdminRoomController::class, 'delete_facility'])->name('delete_facility');
Route::post('/show_facility', [AdminRoomController::class, 'show_facility'])->name('show_facility');
Route::post('/update_facility', [AdminRoomController::class, 'update_facility'])->name('update_facility');

Route::post('/add_feature', [AdminRoomController::class, 'add_feature'])->name('add_feature');
Route::post('/dealte_feature', [AdminRoomController::class, 'dealte_feature'])->name('dealte_feature');
Route::post('/view_feature', [AdminRoomController::class, 'view_feature'])->name('view_feature');
Route::post('/update_feature', [AdminRoomController::class, 'update_feature'])->name('update_feature');

Route::post('/admin-google', [AdminAjaxController::class, 'google_handler'])->name('google');
Route::post('/admin-ajax-login', [AdminAjaxController::class, 'index'])->name('admin-ajax-login');
Route::post('/admin_logout', [AdminAjaxController::class, 'logout_ajax'])->name('admin_logout');

Route::get('/admin-login', [AdminNavigationController::class, 'index'])->name('admin-login');

Route::middleware(['admin'])->group(function () {
  Route::get('/dashboard', [AdminNavigationController::class, 'dashboard'])->name('dashboard');
  Route::get('/room', [AdminNavigationController::class, 'room'])->name('room');
  Route::get('/booked', [AdminNavigationController::class, 'booked'])->name('booked');
  Route::get('/dashboardbtn', [AdminNavigationController::class, 'dashboardbtn'])->name('dashboardbtn');
  Route::get('/add_room', [AdminNavigationController::class, 'addRoom'])->name('add_room');
  Route::get('/view_room', [AdminNavigationController::class, 'viewRoom'])->name('view_room');
  Route::get('/roomtable', [AdminNavigationController::class, 'roomtable'])->name('roomtable');
  Route::get('/category', [AdminNavigationController::class, 'category'])->name('category');
  Route::get('/category_tb', [AdminNavigationController::class, 'category_tb'])->name('category_tb');
  Route::get('/facility', [AdminNavigationController::class, 'facility'])->name('facility');
  Route::get('/facilitytable', [AdminNavigationController::class, 'facilitytable'])->name('facilitytable');
  Route::get('/feature', [AdminNavigationController::class, 'feature'])->name('feature');
  Route::get('/featuretable', [AdminNavigationController::class, 'featuretable'])->name('featuretable');
});

Route::get('/admin_profile', function () {
  return view('Admin.Auth.admin_profile');
})->name('admin_profile');
// Ajax Route
