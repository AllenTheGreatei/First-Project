<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room_Category extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'room__categories';

  protected $fillable = ['name'];
}
