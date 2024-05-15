<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\RoomBooked;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;

class StripeController extends Controller
{
  public function checkout()
  {
    return view('checkout');
  }

  public function session(Request $request)
  {
    $array_checkout = [];
    $is_retrive = false;
    $notice = $request->get('notice');
    $room_id = $request->get('idholder');
    if ($notice) {
      $room_id = $request->get('idholder');
    } else {
      try {
        $room_id = Crypt::decryptstring($room_id);
      } catch (DecryptException $e) {
        return response()->json(['message' => 'invalid_id']);
      }
    }
    $bookedroom = RoomBooked::where('room_id', $room_id)
      ->orderBy('check_in')
      ->get();
    $i = 0;

    foreach ($bookedroom as $element) {
      $array_checkout[$i] = []; // Initialize the inner array at index i

      $array_checkout[$i][0] = $element['check_in']; // Assign check_in value to the inner array
      $array_checkout[$i][1] = $element['check_out']; // Assign check_out value to the inner array

      $i++;
    }

    $checkin = $request->get('start_date'); // assuming you're getting the values from a form
    $checkout = $request->get('end_date');

    function isOverlap($checkin, $checkout, $array_checkout)
    {
      $checkInDate = Carbon::parse($checkin);
      $checkOutDate = Carbon::parse($checkout);

      foreach ($array_checkout as $dates) {
        $existingCheckInDate = Carbon::parse($dates[0]);
        $existingCheckOutDate = Carbon::parse($dates[1]);

        // Check if either the check-in or check-out date falls within the range
        if (
          ($existingCheckInDate >= $checkInDate && $existingCheckInDate <= $checkOutDate) ||
          ($existingCheckOutDate >= $checkInDate && $existingCheckOutDate <= $checkOutDate)
        ) {
          return true; // Overlapping date range found
        }
      }

      return false; // No overlapping date range found
    }

    if (isOverlap($checkin, $checkout, $array_checkout)) {
      return redirect()
        ->away(route('rooms'))
        ->with(['paid' => 'failed', 'in' => $checkin, 'out' => $checkout]);
      // return false;
    } else {
      $is_retrive = true;
    }

    if ($is_retrive) {
      // header('Access-Control-Allow-Origin: *');

      $id = $request->get('idholder');

      $notice = $request->get('notice');
      $name = $request->get('room_n');
      $totalamount = $request->get('real_total');
      $checkin = $request->get('start_date');
      $checkout = $request->get('end_date');
      session([
        'notice' => $notice,
        'rname' => $name,
        'totalamount' => $totalamount,
        'checkin' => $checkin,
        'checkout' => $checkout,
        'idholder' => $id,
      ]);
      \Stripe\Stripe::setApiKey(config('stripe.sk'));
      // $name = 'Alien';
      // $totalamount = 1000;
      $two0 = '00';
      $total = "$totalamount$two0";
      // $img = env('APP_URL') . '/RoomImg/1714405282.jpg';
      $session = \Stripe\Checkout\Session::create([
        'line_items' => [
          [
            'price_data' => [
              'currency' => 'PHP',
              'product_data' => [
                'name' => $name,
              ],
              'unit_amount' => $total,
            ],
            'quantity' => 1,
          ],
        ],
        'mode' => 'payment',
        'success_url' => route('mybookings'),
        'cancel_url' => route('rooms'),
      ]);
    }
    return redirect()
      ->away($session->url)
      ->with(['paid' => 'success']);
  }
}
