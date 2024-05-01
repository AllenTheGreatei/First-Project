<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuth extends Middleware
{
  /**
   * Handle an incoming request.
   *
   */
  public function handle($request, Closure $next, ...$guards)
  {
    // Check if the user is authenticated and is an admin

    if (Auth::guard('admin')->check()) {
      return $next($request);
    }

    // If not an admin, redirect or return unauthorized response
    return redirect()->route('admin-login'); // Redirect to admin login page
    // or return response()->json(['error' => 'Unauthorized'], 401); // Return unauthorized response
  }
}
