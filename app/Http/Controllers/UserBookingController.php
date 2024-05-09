<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Room;
use App\Models\Booking;
use App\Models\RoomBooked;

class UserBookingController extends Controller
{
  public function display_book(Request $request)
  {
    $notice = $request->notice;
    if ($notice) {
      $id = $request->id;
    } else {
      try {
        $id = Crypt::decryptstring($request->id);
      } catch (DecryptException $e) {
        return response()->json(['message' => 'invalid_id']);
      }
    }

    $bookedroom = RoomBooked::where('room_id', $id)
      ->orderBy('check_in')
      ->get();

    $show_room = Room::where('id', $id)->first();
    if ($show_room) {
      return response()->json(['message' => 'success', 'room' => $show_room, 'booked' => $bookedroom]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function booked(Request $request)
  {
    $transaction = $request->transaction;

    $room_id = $transaction['room_id'];

    if ($transaction['notice']) {
      $room_id = $transaction['room_id'];
    } else {
      try {
        $room_id = Crypt::decryptstring($room_id);
      } catch (DecryptException $e) {
        return response()->json(['message' => 'invalid_id']);
      }
    }

    $checkin = $transaction['checkin'];
    $checkout = $transaction['checkout'];
    $total_amount = intval($transaction['total_price']);

    $user_id = session('user_id');

    $new_transaction = Booking::create([
      'user_id' => $user_id,
      'room_id' => $room_id,
      'total_amount' => $total_amount,
      'check_in' => $checkin,
      'check_out' => $checkout,
    ]);

    $date = RoomBooked::create([
      'room_id' => $room_id,
      'transaction_id' => $new_transaction->id,
      'check_in' => $checkin,
      'check_out' => $checkout,
    ]);

    if ($new_transaction && $date) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'Failed']);
    }
  }

  public function mybookings()
  {
    $id = session('user_id');
    
    $transaction = Booking::where('user_id', $id)
      ->orderByDesc('created_at')
      ->get();
    $rooms = Room::all();
    
    return view('User.MyBookings', compact('transaction', 'rooms'));
  }
}
