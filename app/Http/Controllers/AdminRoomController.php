<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Room;
use App\Models\Room_Category;
use App\Models\Facility;
use App\Models\Feature;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\File;

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

  public function submit_edit_room(Request $request)
  {
    $r_id = request('id');
    $r_name = $request->input('r_name');
    $r_price = $request->input('r_price');
    $r_category = $request->input('r_category');
    $r_facility = $request->input('r_facility');
    $r_feature = $request->input('r_feature');
    $r_adult = $request->input('r_adult');
    $r_children = $request->input('r_children');
    $r_description = $request->input('r_description');
    $img = $request->file('image');
    if ($img === null) {
      $update_room = Room::where('id', $r_id)->update([
        'room_name' => $r_name,
        'price' => $r_price,
        'room_category' => $r_category,
        'room_features' => $r_feature,
        'room_facilities' => $r_facility,
        'adult' => $r_adult,
        'children' => $r_children,
        'description' => $r_description,
      ]);

      if ($update_room) {
        return response()->json(['message' => 'success']);
      } else {
        return response()->json(['message' => 'failed']);
      }
    } else {
      $get_img = Room::where('id', $r_id)->first();
      $old_img = $get_img->image;
      $name = pathinfo($old_img, PATHINFO_FILENAME);
      File::delete($name);
      $validator = Validator::make($request->all(), [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      ]);

      if ($validator->fails()) {
        return response()->json(['error' => 'notvalidimage']);
      }

      $extension = $img->getClientOriginalExtension();
      $imgname = $name . '.' . $extension;
      $path = $img->move(public_path('RoomImg'), $imgname);
      $update_room = Room::where('id', $r_id)->update([
        'room_name' => $r_name,
        'price' => $r_price,
        'room_category' => $r_category,
        'room_features' => $r_feature,
        'room_facilities' => $r_facility,
        'adult' => $r_adult,
        'children' => $r_children,
        'description' => $r_description,
        'image' => $imgname,
      ]);

      if ($update_room) {
        return response()->json(['message' => 'success']);
      } else {
        return response()->json(['message' => 'failed']);
      }
    }
  }

  public function delete_room(Request $request)
  {
    try {
      $id = Crypt::decryptstring($request->room_id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }

    $deleted = Room::where('id', $id)->delete();

    if ($deleted) {
      return response()->json(['message' => 'success', 'id' => $id]);
    } else {
      return response()->json(['message' => 'error']);
    }
  }

  public function retrive_room(Request $request)
  {
    try {
      $room_id = Crypt::decryptstring($request->room_id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }

    $room = Room::where('id', $room_id)->first();

    $room_info = [
      'r_id' => $room->id,
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
    try {
      $id = Crypt::decryptstring($request->id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }

    $delete = Room_Category::where('id', $id)->delete();
    if ($delete) {
      return response()->json(['message' => 'success', 'id' => $id]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function show_category(Request $request)
  {
    try {
      $id = Crypt::decryptstring($request->id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }

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
    try {
      $id = Crypt::decryptstring($request->id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }

    $delete_facility = Facility::where('id', $id)->delete();
    if ($delete_facility) {
      return response()->json(['message' => 'success', 'id' => $id]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function show_facility(Request $request)
  {
    try {
      $id = Crypt::decryptstring($request->id);
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }

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

  public function add_feature(Request $request)
  {
    $name = $request->name;
    $new_feature = Feature::create(['name' => $name]);

    if ($new_feature) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function dealte_feature()
  {
    try {
      $id = Crypt::decryptstring(request('id'));
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }
    $del = Feature::where('id', $id)->delete();
    if ($del) {
      return response()->json(['message' => 'success', 'id' => $id]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function view_feature()
  {
    try {
      $id = Crypt::decryptstring(request('id'));
    } catch (DecryptException $e) {
      return response()->json(['message' => 'invalid_id']);
    }
    $view = Feature::where('id', $id)->first();
    if ($view) {
      return response()->json(['message' => 'success', 'feature' => $view]);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }

  public function update_feature(Request $request)
  {
    $id = request('id');
    $name = $request->name;
    $feature = Feature::where('id', $id)->update(['name' => $name]);
    if ($feature) {
      return response()->json(['message' => 'success']);
    } else {
      return response()->json(['message' => 'failed']);
    }
  }
}
