<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\Email;

class UserAjaxActionController extends Controller
{
  public function login_ajax(Request $request)
  {
    try {
      $this->CheckAttempt();
      try {
        $credentials = $request->validate([
          'email' => ['required', 'email'],
          'password' => ['required'],
        ]);
      } catch (Exception $e) {
        return response()->json(['message' => 'email']);
      }

      if (Auth::attempt($credentials)) {
        $user = Auth::user();
        if ($user->email_verified_at) {
          session(['username' => $user->first_name . ' ' . $user->last_name]);
          RateLimiter::clear($this->throttleKey());
          return response()->json(['message' => 'success']);
        } else {
          return response()->json(['message' => 'notverified']);
        }
      } else {
        RateLimiter::hit($this->throttleKey());
        return response()->json(['message' => 'error']);
      }
    } catch (Exception $e) {
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

  public function logout_ajax()
  {
    Auth::logout();
    request()
      ->session()
      ->invalidate();
    request()
      ->session()
      ->regenerateToken();
    return response()->json(['message' => 'success']);
  }

  public function google_handler(Request $request)
  {
    $gemail = request('email');
    $user = User::where('email', $gemail)->first();
    if ($user->email_verified_at) {
      if ($user) {
        Auth::login($user);
        session(['username' => $user->first_name . ' ' . $user->last_name]);
        return response()->json(['message' => 'success']);
      } else {
        return response()->json(['message' => 'errror']);
      }
    } else {
      return response()->json(['message' => 'notverified']);
    }
  }

  // public function sendOtp(Request $request)
  // {
  //   try {
  //     $credentials = $request->validate([
  //       'email' => ['required', 'email'],
  //     ]);
  //   } catch (\Throwable $th) {
  //     return response()->json(['message' => 'wrongformat']);
  //   }

  //   // check if email already exist
  //   $check = User::where('email', request('email'))->first();
  //   if ($check) {
  //     return response()->json(['message' => 'exist']);
  //   } else {
  //     //  Send Otp here
  //     $randomOtp = random_int(100000, 999999);
  //     $toEmail = request('email');
  //     $subject = 'One Time Password';
  //     $content = $randomOtp;
  //     try {
  //       Mail::to($toEmail)->send(new Email($subject, $content, $toEmail));

  //       session(['email' => request('email'), 'password' => request('password'), 'otp' => $randomOtp]);
  //       return response()->json(['message' => 'success']);
  //     } catch (\Exception $e) {
  //       return response()->json(['message' => $e->getMessage()]);
  //     }
  //   }
  // }

  // public function validate_otp(Request $request)
  // {
  //   if (session('otp') == request('otp') && request('otp') != '') {
  //     Session::forget('otp');
  //     return response()->json(['message' => 'success']);
  //   } else {
  //     return response()->json(['message' => 'fail']);
  //   }
  // }

  public function register(Request $request)
  {
    // Register User
    $check = User::where('email', request('email'))->first();
    if ($check) {
      return response()->json(['message' => 'exist']);
    } else {
      $query = User::create([
        'first_name' => request('fname'),
        'last_name' => request('lname'),
        'address' => 'Brgy.' . request('barangay') . ', ' . request('municipal') . ', ' . request('province'),
        'contact_no' => request('contactNo'),
        'email' => request('email'),
        'password' => bcrypt(request('password')),
      ]);

      if ($query) {
        event(new Registered($query));
        // Auth::login($query);

        session(['username' => request('fname') . ' ' . request('lname')]);
        Session::forget(['email', 'password']);
        return response()->json(['message' => 'success']);
      } else {
        return response()->json(['message' => 'fail']);
      }
    }
  }
}
