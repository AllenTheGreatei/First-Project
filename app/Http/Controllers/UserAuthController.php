<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAuthController extends Controller
{
  public function index()
  {
    return view('User/Auth/login');
  }
  public function register()
  {
    return view('User/Auth/Register');
  }

  // public function register2()
  // {
  //   return view('User/Auth/Register2');
  // }

  // public function otp()
  // {
  //   return view('User/Auth/otp');
  // }
}
