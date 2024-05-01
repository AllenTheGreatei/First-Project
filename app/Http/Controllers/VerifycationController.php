<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class VerifycationController extends Controller
{
  // use VerifiesEmails;

  // /**
  //  * Where to redirect users after verification.
  //  *
  //  * @var string
  //  */
  // protected $redirectTo = '/home'; // Change this to your desired redirect path

  // /**
  //  * Create a new controller instance.
  //  *
  //  * @return void
  //  */
  // // public function __construct()
  // // {
  // //   $this->middleware('auth');
  // //   $this->middleware('signed')->only('verify');
  // //   $this->middleware('throttle:6,1')->only('verify', 'resend');
  // // }

  public function verify($id, $hash)
  {
    $user = User::find($id);

    if (!$user || !hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
      return redirect()
        ->route('login')
        ->with('error', 'Invalid verification link.');
    }

    if ($user->hasVerifiedEmail()) {
      return redirect()
        ->route('login')
        ->with('success', 'Email already verified.');
    }

    if ($user->markEmailAsVerified()) {
      event(new Verified($user));
      return redirect()
        ->route('login')
        ->with('success', 'Email verified successfully.');
    }

    return redirect()
      ->route('login')
      ->with('error', 'Unable to verify email.');
  }
}
