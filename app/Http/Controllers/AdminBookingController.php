<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminBookingController extends Controller
{
  public function pay_display(Request $request)
  {
    try {
      $id = Crypt::decryptstring($request->id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }

    $amount = Booking::where('id', $id)->first();
    $a = $amount->total_amount;
    return response()->json(['message' => 'success', 'amount' => $a]);
  }

  public function pay(Request $request)
  {
    try {
      $id = Crypt::decryptstring($request->id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }
    $update = Booking::where('id', $id)->update([
      'cash' => $request->cash,
      'change' => $request->change,
      'status' => 'Paid',
    ]);

    if ($update) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }
}
