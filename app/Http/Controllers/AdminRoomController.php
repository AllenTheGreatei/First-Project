<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Room;

class AdminRoomController extends Controller
{
  public function index()
  {
    //
  }

  public function addNewRoom(Request $request)
  {
    $newRoom = $request->input('new_room');

    $validator = Validator::make($request->all(), [
      'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => 'notvalidimage']);
    }

    $img = $request->file('image');
    $extension = $img->getClientOriginalExtension();
    $imgname = time() . '.' . $extension;
    $path = $img->move(public_path('RoomImg'), $imgname);

    $room_name = $request->input('roomName');
    $room_price = $request->input('price');
    $room_category = $request->input('category');
    $roomFeatures = $newRoom['room_features'];
    $roomFacility = $newRoom['room_facility'];
    $adult = $request->input('adult');
    $children = $request->input('children');
    $description = $request->input('description');

    $room = Room::create([
      'room_name' => $room_name,
      'price' => $room_price,
      'room_category' => $room_category,
      'room_features' => $roomFeatures,
      'room_facilities' => $roomFacility,
      'adult' => $adult,
      'children' => $children,
      'description' => $description,
      'image' => $imgname,
    ]);

    if ($room) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function delete_room(Request $request)
  {
    $id = $request->room_id;

    $deleted = Room::where('id', $id)->delete();

    if ($deleted) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'error']);
    }
  }
}
