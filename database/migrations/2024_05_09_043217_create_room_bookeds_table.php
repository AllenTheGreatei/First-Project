<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('room_bookeds', function (Blueprint $table) {
      $table->id();
      $table->BigInteger('room_id');
      $table->BigInteger('transaction_id');
      $table->timestamp('check_in');
      $table->timestamp('check_out');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('room_bookeds');
  }
};
