<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('User/Auth/login');
  }

  public function dashboard(Request $request)
  {
    // return view('Admin/dashboard/dashboard');
  }

  public function room()
  {
    return view('Admin/__div_list/room');
  }

  public function booked()
  {
    return view('Admin/__div_list/booked');
  }

  public function dashboardbtn()
  {
    // return view('Admin/__div_list/dashboard');
  }
}
