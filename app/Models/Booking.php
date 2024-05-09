<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'bookings';

  protected $fillable = ['user_id', 'room_id', 'check_in', 'check_out', 'total_amount', 'status', 'change', 'cash'];
}
