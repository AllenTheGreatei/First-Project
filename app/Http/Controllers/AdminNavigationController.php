<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Room_Category;
use App\Models\Facility;
use App\Models\Feature;
use App\Models\Admin;

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
    $categories = Room_Category::all();
    $facilities = Facility::all();
    $features = Feature::all();
    return view('Admin.__div_list.add_room', compact('categories', 'facilities', 'features'));
  }

  public function viewRoom()
  {
    $rooms = Room::all();
    $facilities = Facility::all();
    $features = Feature::all();
    $categories = Room_Category::all();
    return view('Admin.__div_list.view_room', compact('rooms', 'features', 'facilities', 'categories'));
  }

  public function roomtable()
  {
    $rooms = Room::all();
    return view('Admin.__sub.room_table', compact('rooms'));
  }

  public function category()
  {
    $categories = Room_Category::all();
    return view('Admin.__div_list.category', compact('categories'));
  }

  public function category_tb()
  {
    $categories = Room_Category::all();
    return view('Admin.__sub.categorytable', compact('categories'));
  }

  public function facility()
  {
    $facilities = Facility::all();
    return view('Admin.__div_list.facility', compact('facilities'));
  }

  public function facilitytable()
  {
    $facilities = Facility::all();
    return view('Admin.__sub.facilitytable', compact('facilities'));
  }

  public function feature()
  {
    $features = Feature::all();
    return view('Admin.__div_list.feature', compact('features'));
  }

  public function featuretable()
  {
    $features = Feature::all();
    return view('Admin.__sub.feature', compact('features'));
  }

  public function admin_profile()
  {
    $adminid = session('adminId');
    $admin = Admin::where('id', $adminid)->first();
    return view('Admin.Auth.admin_profile', compact('admin')); 
  }
}
