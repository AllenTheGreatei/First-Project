<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Room;
use App\Models\Room_Category;
use App\Models\Facility;

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

  public function retrive_room(Request $request)
  {
    $room_id = $request->room_id;

    $room = Room::where('id', $room_id)->first();

    $room_info = [
      'r_name' => $room->room_name,
      'r_price' => $room->price,
      'r_category' => $room->room_category,
      'r_facilities' => $room->room_facilities,
      'r_features' => $room->room_features,
      'r_adult' => $room->adult,
      'r_children' => $room->children,
      'r_description' => $room->description,
      'r_img' => $room->image,
    ];

    if ($room) {
      return response()->json(['message' => 'success', 'room' => $room_info]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function add_category(Request $request)
  {
    $category_name = $request->category_name;

    $category = Room_Category::create(['name' => $category_name]);
    $newCategoryId = $category->id;
    if ($category) {
      $allcategory = Room_Category::all();
      return response()->json(['message' => 'success', 'allCategory' => $allcategory]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function delete_category(Request $request)
  {
    $id = $request->id;
    $delete = Room_Category::where('id', $id)->delete();
    if ($delete) {
      return response()->json(['message' => 'success', 'id' => $id]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function show_category(Request $request)
  {
    $id = $request->id;
    $find = Room_Category::where('id', $id)->first();
    if ($find) {
      return response()->json(['message' => 'success', 'category' => $find]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function save_edited_category(Request $request)
  {
    $id = $request->id;
    $name = $request->name;

    $update = Room_Category::where('id', $id)->update([
      'name' => $name,
    ]);
    if ($update) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function add_facility(Request $request)
  {
    $facility_name = $request->facility_n;

    $new_facility = Facility::create(['name' => $facility_name]);

    if ($new_facility) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function delete_facility(Request $request)
  {
    $id = $request->id;
    $delete_facility = Facility::where('id', $id)->delete();
    if ($delete_facility) {
      return response()->json(['message' => 'success', 'id' => $id]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function show_facility(Request $request)
  {
    $id = $request->id;
    $facility = Facility::where('id', $id)->first();
    if ($facility) {
      return response()->json(['message' => 'success', 'facility' => $facility]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function update_facility(Request $request)
  {
    $id = $request->id;
    $name = $request->name;
    $facility = Facility::where('id', $id)->update(['name' => $name]);
    if ($facility) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }
}
