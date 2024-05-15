<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Facility;
use App\Models\RoomBooked;
use App\Models\Room_Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Booking;
use Illuminate\Contracts\Encryption\DecryptException;

class UserNavigationController extends Controller
{
  public function index()
  {
    $weatherResponse = $this->getWeather();

    // Extract the JSON content from the response
    $weatherData = json_decode($weatherResponse->getContent(), true);

    $delete_booking = RoomBooked::where('check_out', '<', now())->delete();
    $sss = Booking::where('check_out', '<', now())->update([
      'status' => 'Checked Out',
    ]);
    // Return the weather data to the view
    // return view('show', ['weatherData' => $weatherData]);
    return view('User/Home', ['weatherData' => $weatherData]);
  }

  public function rooms(Request $request)
  {
    $rooms = Room::all();
    $aminities = Facility::all();
    $categories = Room_Category::all();
    return view('User/rooms', compact('rooms', 'aminities', 'categories'));
  }

  public function getWeather()
  {
    // Define the city name
    $city = 'Matalom';

    try {
      // Initialize Guzzle HTTP client
      $client = new Client();

      // Make request to OpenWeatherMap API
      $response = $client->get('http://api.openweathermap.org/data/2.5/weather', [
        'query' => [
          'q' => $city,
          'appid' => 'aa365767fd17c38ec8e27ae743fa8176',
          'units' => 'metric',
        ],
      ]);

      // Decode the JSON response
      $data = json_decode($response->getBody(), true);

      // Check if the API returned an error
      if (isset($data['cod']) && $data['cod'] != 200) {
        return response()->json(['error' => $data['message']], 400);
      }

      // Return the weather data
      return response()->json($data);
    } catch (RequestException $e) {
      // Handle Guzzle HTTP request exceptions
      return response()->json(['error' => 'Failed to fetch weather data.'], 500);
    }
  }

  public function filterbydate(Request $request)
  {
    $fromdate = $request->fromdate;
    $enddate = $request->enddate;

    $bookedRooms = DB::table('rooms')
      ->join('room_bookeds', 'rooms.id', '=', 'room_bookeds.room_id')
      ->select('rooms.*', 'room_bookeds.*')
      ->whereDate('room_bookeds.check_in', '<=', $enddate)
      ->whereDate('room_bookeds.check_out', '>=', $fromdate)
      ->get();

    $bookedRoomIds = [];
    $id = 0;
    foreach ($bookedRooms as $booked) {
      if ($id === $booked->room_id) {
        // $index = array_search($booked->room_id, $bookedRoomIds);
        // if ($index !== false) {
        //   // unset($bookedRoomIds[$index]);
        //   // continue;
        // }
        continue;
      }
      $id = $booked->room_id;
      $bookedRoomIds[] = $booked->room_id;
      // $bookedRooms = DB::table('rooms')
      //   ->join('room_bookeds', 'rooms.id', '=', 'room_bookeds.room_id')
      //   ->select('rooms.*')
      //   ->where('rooms.id', '!=', $booked->room_id)
      //   ->get();
      // if ($bookedRooms) {
      //   $bookedRoomIds[] = $bookedRooms;
      // }
    }
    $rooms = Room::whereNotIn('id', $bookedRoomIds)->get();

    return response()->json(['message' => 'success', 'rooms' => $rooms]);
    // $roomav = [];
  }

  public function moredetails(Request $request)
  {
    // try {
    //   $id = Crypt::decryptstring($request->id);
    // } catch (DecryptException $e) {
    //   return response()->json(['message' => 'invalid_id']);
    // }
    $id = $request->id;

    $room = Room::where('id', $id)->first();

    $aminities = explode(',', $room->room_facilities);
    $features = explode(',', $room->room_features);
    // var_dump($aminities);

    return view('User.MoreDetails', compact('room', 'aminities', 'features'));
  }

  public function filterby_category(Request $request)
  {
    $selected = $request->selected;

    $rooms = Room::where('room_category', $selected)->get();

    return response()->json(['message' => 'success', 'rooms' => $rooms]);
  }

  public function filterby_adult(Request $request)
  {
    $adult = $request->adult;
    if ($adult == null) {
      $adult = 1;
    }
    $rooms = Room::where('adult', '>=', $adult)->get();
    if ($rooms) {
      return response()->json(['message' => 'success', 'rooms' => $rooms]);
    }
  }

  public function filterby_age(Request $request)
  {
    $adult = $request->adult;
    $children = $request->children;
    if ($adult == null) {
      $adult = 1;
    }
    if ($children == null) {
      $children = 1;
    }
    $rooms = Room::where('adult', '>=', $adult)
      ->where('children', '>=', $children)
      ->get();
    if ($rooms) {
      return response()->json(['message' => 'success', 'rooms' => $rooms]);
    }
  }

  public function filterby_aminities(Request $request)
  {
    $selected = $request->selected;
    $rooms = Room::all();
    $id = [];
    foreach ($rooms as $room) {
      $facilities = explode(',', $room->room_facilities);
      foreach ($facilities as $facility) {
        if ($selected === $facility) {
          array_push($id, $room->id);
        }
      }
    }

    $rooms = Room::whereIn('id', $id)->get();
    return response()->json(['message' => 'success', 'rooms' => $rooms]);
  }
}
