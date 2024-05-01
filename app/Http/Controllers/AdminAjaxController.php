<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\RateLimiter;

class AdminAjaxController extends Controller
{
  public function index(Request $request)
  {
    // $password = '123';
    // Admin::create([
    //   'first_name' => 'Mardods',
    //   'last_name' => 'Da Greate',
    //   'username' => 'MardodsGwapo',
    //   'email' => 'pagalnella321@gmail.com',
    //   'password' => bcrypt($password),
    // ]);
    // return response()->json(['message' => 'success']);
    try {
      $this->CheckAttempt();
      $email = request('email');
      $password = request('password');

      $admin = Admin::where('email', $email)->first();

      if ($admin && Hash::check($password, $admin->password)) {
        $user = Auth::guard('admin')->user();

        if ($admin->email_verified_at) {
          Auth::guard('admin')->login($admin);

          session(['adminName' => $admin->first_name . ' ' . $admin->last_name]);
          RateLimiter::clear($this->throttleKey());
          return response()->json(['message' => 'success']);
        } else {
          return response()->json(['message' => 'notverified']);
        }
      } else {
        RateLimiter::hit($this->throttleKey());
        return response()->json(['message' => 'failed']);
      }
    } catch (\Throwable $e) {
      return response()->json(['message' => 'max_attempt', 'time' => $e->getMessage()]);
    }
  }

  public function CheckAttempt()
  {
    $seconds = RateLimiter::availableIn($this->throttleKey());
    if (RateLimiter::tooManyAttempts($this->throttleKey(), 2)) {
      throw new Exception(gmdate($seconds), 494);
    }
  }

  public function throttleKey()
  {
    return Str::lower(request('email') . '|' . request()->ip());
  }

  public function google_handler(Request $request)
  {
    $gemail = request('email');
    $user = Admin::where('email', $gemail)->first();
    if ($user->email_verified_at) {
      if ($user) {
        Auth::guard('admin')->login($user);
        session(['adminName' => $user->first_name . ' ' . $user->last_name]);
        return response()->json(['message' => 'success']);
      } else {
        return response()->json(['message' => 'errror']);
      }
    } else {
      return response()->json(['message' => 'notverified']);
    }
  }

  public function admin_logout()
  {
    Auth::guard('admin')->logout();
    request()
      ->session()
      ->invalidate();
    request()
      ->session()
      ->regenerateToken();
    return response()->json(['message' => 'success']);
  }
}
