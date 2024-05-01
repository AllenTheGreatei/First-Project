<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
  use HasFactory;

  protected $table = 'rooms';

  protected $fillable = [
    'room_name',
    'price',
    'room_category',
    'room_features',
    'room_facilities',
    'adult',
    'children',
    'description',
    'image',
  ];
}
