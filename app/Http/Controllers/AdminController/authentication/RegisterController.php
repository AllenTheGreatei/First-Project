<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
  public function index()
  {
    return view('Register');
  }

  public function register2()
  {
    return view('Register2');
  }
}
