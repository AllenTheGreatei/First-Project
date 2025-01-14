<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBooked extends Model
{
  use HasFactory;

  protected $table = 'room_bookeds';

  protected $fillable = ['room_id', 'transaction_id', 'check_in', 'check_out'];
}
