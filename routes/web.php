<?php

use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserAjaxActionController;
use App\Http\Controllers\UserNavigationController;
use App\Http\Controllers\UserBookingController;

use App\Http\Controllers\AdminNavigationController;
use App\Http\Controllers\AdminAjaxController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\VerifycationController;
use App\Http\Controllers\AdminBookingController;

use App\Http\Controllers\StripeController;

// Route::options('{any}', function (Request $request) {
//   return response('', 204)
//     ->header('Access-Control-Allow-Origin', '*')
//     ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
//     ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
// })->where('any', '.*');

// Route::post('/proxy-stripe', function (Request $request) {
//   $response = Http::post(
//     'https://checkout.stripe.com/c/pay/cs_test_a1LD1QgPbvzyJQphcGXLQYqlE0z4iodEkHO4o3bdaQzkBAa7AKsVOREUD4',
//     $request->all()
//   );
//   return response($response->body(), $response->status())->header('Content-Type', $response->header('Content-Type'));
// });

Route::get('/', [UserNavigationController::class, 'index'])->name('home');

// Landing Page Route
// Route::get('/register', [RegisterController::class, 'index'])->name('register');
// Route::get('/register2', [RegisterController::class, 'register2'])->name('register2');

// Route::get('/login', [LoginBasic::class, 'index'])->name('login');

// USER
// Auth::routes([
//   'verify' => true,
// ]);.
// Route::post('/session', function (Request $request) {
//   // Extract data from the request if needed
//   $requestData = $request->all();

//   // Make request to Stripe API
//   $response = Http::withHeaders([
//     'Authorization' => 'Bearer your_stripe_secret_key',
//     'Content-Type' => 'application/json',
//   ])->post('https://api.stripe.com/v1/your-endpoint', $requestData);

//   // Forward response from Stripe API to frontend
//   return $response->json();
// });

// display_book
// Filter
Route::get('hotel-info', function () {
  return view('User.hotel-info');
});

Route::get('contact', function () {
  return view('User.contact');
});

Route::get('about-us', function () {
  return view('User.about-us');
});

Route::post('/cancelbook', [UserBookingController::class, 'cancelbook'])->name('cancelbook');

Route::post('/filterby_aminities', [UserNavigationController::class, 'filterby_aminities'])->name(
  '/filterby_aminities'
);

Route::post('/filterby_age', [UserNavigationController::class, 'filterby_age'])->name('/filterby_age');
Route::post('/filterby_adult', [UserNavigationController::class, 'filterby_adult'])->name('/filterby_adult');
Route::post('/filterby_category', [UserNavigationController::class, 'filterby_category'])->name('/filterby_category');
Route::post('/filterbydate', [UserNavigationController::class, 'filterbydate'])->name('/filterbydate');

Route::post('/display_book', [UserBookingController::class, 'display_book'])->name('display_book');
Route::post('/user-booked', [UserBookingController::class, 'booked'])->name('user-booked');

Route::get('/mybookings', [UserBookingController::class, 'mybookings'])
  ->name('mybookings')
  ->middleware('auth');

Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');
// Route::get('/success', 'App\Http\Controllers\UserNavigationController@rooms')->name('success');
Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');

Route::get('/moredetails/{id}', [UserNavigationController::class, 'moredetails'])->name('moredetails');

Route::get('email/verify/{id}/{hash}', [VerifycationController::class, 'verify'])->name('verification.verify');
Route::get('/rooms', [UserNavigationController::class, 'rooms'])->name('rooms');
Route::get('/home', [UserNavigationController::class, 'index'])->name('home');

Route::get('/forgot-pass-final', function () {
  return view('User.Auth.forgot-pass');
});
Route::post('/user-change-password', [UserAjaxActionController::class, 'user_change_password'])->name(
  'user-change-password'
);

Route::post('/register', [UserAjaxActionController::class, 'register'])->name('register');
Route::post('/validate_otp', [UserAjaxActionController::class, 'validate_otp'])->name('validate_otp');
Route::post('/sendOtp', [UserAjaxActionController::class, 'sendOtp'])->name('sendOtp');
Route::post('/google', [UserAjaxActionController::class, 'google_handler'])->name('google');
Route::post('/login_ajax', [UserAjaxActionController::class, 'login_ajax'])->name('login_ajax');
Route::post('/logout_ajax', [UserAjaxActionController::class, 'logout_ajax'])->name('logout_ajax');

Route::get('/otp', [UserAuthController::class, 'otp'])->name('otp');
Route::get('/register', [UserAuthController::class, 'register'])->name('register');
// Route::get('/register2', [UserAuthController::class, 'register2'])->name('register2');
Route::get('/login', [UserAuthController::class, 'index'])->name('login');
Route::get('forgot-password', function () {
  return view('User.Auth.auth-forgot-password-basic');
})->name('forgot-password');

// ADMIN

Route::post('/pay_display', [AdminBookingController::class, 'pay_display'])->name('pay_display');
Route::post('/pay', [AdminBookingController::class, 'pay'])->name('pay');

Route::post('/admin_confirm_otp', [AdminAjaxController::class, 'admin_confirm_otp'])->name('admin_confirm_otp');
Route::post('/admin_send_otp', [AdminAjaxController::class, 'admin_send_otp'])->name('admin_send_otp');

Route::post('/update_admin_prof', [AdminAjaxController::class, 'update_admin_prof'])->name('update_admin_prof');
Route::post('/change_pass', [AdminAjaxController::class, 'change_pass'])->name('change_pass');

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
  Route::post('search', [AdminNavigationController::class, 'search'])->name('search');
  Route::get('download_report', [AdminAjaxController::class, 'download_report'])->name('download_report');
  Route::post('filter_report', [AdminAjaxController::class, 'filter_report'])->name('filter_report');
  Route::get('reports', [AdminAjaxController::class, 'reports'])->name('reports');
  Route::get('history', [AdminNavigationController::class, 'history'])->name('history');
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
  Route::get('/admin_profile', [AdminNavigationController::class, 'admin_profile'])->name('admin_profile');
  Route::post('/view-reason', [AdminNavigationController::class, 'view_reason'])->name('view-reason');
  Route::post('/cancel-real', [AdminNavigationController::class, 'cancel_real'])->name('cancel-real');
  Route::post('/out', [AdminNavigationController::class, 'out'])->name('out');
  Route::post('/can', [AdminNavigationController::class, 'can'])->name('can');
});

// Route::get('/admin_profile', function () {
//   return view('Admin.Auth.admin_profile');
// })->name('admin_profile');
// Ajax Route
