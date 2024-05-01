<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class AdminNavigationController extends Controller
{
  public function index()
  {
    return view('Admin.Auth.login');
  }

  public function dashboard()
  {
    return view('Admin/dashboard/dashboard');
  }

  public function room()
  {
    $rooms = Room::all();

    return view('Admin/__div_list/room', compact('rooms'));
  }

  public function booked()
  {
    return view('Admin/__div_list/booked');
  }

  public function dashboardbtn()
  {
    return view('Admin/__div_list/dashboard');
  }

  public function addRoom()
  {
    return view('Admin.__div_list.add_room');
  }

  public function viewRoom()
  {
    $rooms = Room::all();
    return view('Admin.__div_list.view_room', compact('rooms'));
  }
}
