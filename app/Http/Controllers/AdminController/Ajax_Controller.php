<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;

class Ajax_Controller extends Controller
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
        $request->session()->put('name', $user->name);
        RateLimiter::clear($this->throttleKey());
        return response()->json(['message' => 'success']);
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
    if ($user) {
      Auth::login($user);
      $request->session()->put('name', $user->name);
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'errror']);
    }
  }
}
