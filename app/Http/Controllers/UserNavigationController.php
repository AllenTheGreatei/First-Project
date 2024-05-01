<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class UserNavigationController extends Controller
{
  public function index()
  {
    return view('User/Home');
  }

  public function rooms()
  {
    $rooms = Room::all();
    return view('User/rooms', compact('rooms'));
  }
}
