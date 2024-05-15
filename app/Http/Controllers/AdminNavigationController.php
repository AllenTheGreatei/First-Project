<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Room_Category;
use App\Models\Facility;
use App\Models\Feature;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use App\Models\RoomBooked;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
    $booked = Booking::where('check_out', '>', now())
      ->where('status', '!=', 'Cancelled')
      ->where('status', '!=', 'Checked Out')
      ->orderBy('room_id')
      ->orderBy('check_in')
      ->get();
    $users = User::all();
    $rooms = Room::all();
    return view('Admin/__div_list/booked', compact('booked', 'users', 'rooms'));
  }

  public function dashboardbtn()
  {
    $booked = Booking::where('status', 'Paid')
      ->where('check_out', '>', now())
      ->orderBy('room_id')
      ->orderBy('check_in')
      ->get();

    $cancel = Booking::where('status', '=', 'Cancelled')->get();
    // ->where('updated_at', '=', now())

    $currentMonth = Carbon::now()->month;
    $total_amount = Booking::whereMonth('check_in', $currentMonth)
      ->whereMonth('check_out', $currentMonth)
      ->Where('status', '=', 'Checked Out')
      ->get();
    $total = 0;
    foreach ($total_amount as $totals) {
      $total += $totals->total_amount;
    }

    $previousMonth = Carbon::now()->subMonth()->month;
    $last_month = Booking::whereMonth('check_in', $previousMonth)
      ->orWhereMonth('check_out', $previousMonth)
      ->get();
    $lastmonth_total = 0;
    foreach ($last_month as $totals) {
      $lastmonth_total += $totals->total_amount;
    }

    $users = User::where('email_verified_at', '!=', null)->get();
    $rooms = Room::all();
    $facilities = Facility::all();
    $features = Feature::all();
    $categories = Room_Category::all();
    return view(
      'Admin/__div_list/dashboard',
      compact('rooms', 'facilities', 'features', 'categories', 'booked', 'total', 'lastmonth_total', 'users', 'cancel')
    );
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

  public function history()
  {
    $booked = Booking::where('status', 'Paid')
      ->where('check_out', '<', now())
      ->update([
        'status' => 'Checked Out',
      ]);
    $booked = Booking::where('status', 'Paid')
      ->where('check_out', '<', now())
      ->orWhere('status', '=', 'Cancelled')
      ->orWhere('status', '=', 'Checked Out')
      ->orderBy('room_id')
      ->orderBy('check_in')
      ->get();
    $users = User::all();
    $rooms = Room::all();
    return view('Admin/__div_list/history', compact('booked', 'users', 'rooms'));
  }

  public function search(Request $request)
  {
    $search = $request->search;

    $users = User::where('first_name', 'like', '%' . $search . '%')
      ->orWhere('last_name', 'like', '%' . $search . '%')
      ->get();
    $booked = Booking::where('status', 'Paid')
      ->where('check_out', '>', now())
      ->orderBy('room_id')
      ->orderBy('check_in')
      ->get();
    $rooms = Room::all();

    return response()->json(['message' => 'success', 'users' => $users, 'booked' => $booked, 'rooms' => $rooms]);
  }

  public function view_reason(Request $request)
  {
    $id = $request->id;
    $g = Booking::where('id', $id)->first();
    $data = $g->reason;
    return response()->json(['message' => 'success', 'data' => $data]);
  }

  public function cancel_real(Request $request)
  {
    $id = $request->id;

    $update = Booking::where('id', $id)->update([
      'status' => 'Cancelled',
    ]);
    $hhh = RoomBooked::where('transaction_id', $id)->delete();

    return response()->json(['message' => 'success']);
  }

  public function out(Request $request)
  {
    try {
      $id = Crypt::decryptstring($request->id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }
    $sss = RoomBooked::where('transaction_id', $id)->delete();
    $sss = Booking::where('id', $id)->update([
      'status' => 'Checked Out',
    ]);

    return response()->json(['message' => 'success']);
  }

  public function can(Request $request)
  {
    try {
      $id = Crypt::decryptstring($request->id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }
    $sss = RoomBooked::where('transaction_id', $id)->delete();
    $sss = Booking::where('id', $id)->update([
      'status' => 'Cancelled',
    ]);
    return response()->json(['message' => 'success']);
  }
}
