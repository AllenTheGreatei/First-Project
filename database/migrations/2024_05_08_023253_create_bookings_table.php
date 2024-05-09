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
    Schema::create('bookings', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('room_id');
      $table->timestamp('check_in');
      $table->timestamp('check_out');
      $table->bigInteger('total_amount');
      $table->string('status')->default('Pending');
      $table->bigInteger('change')->nullable();
      $table->bigInteger('cash')->nullable();
      $table->timestamps(); // This will create 'created_at' and 'updated_at' timestamps
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('bookings');
  }
};
