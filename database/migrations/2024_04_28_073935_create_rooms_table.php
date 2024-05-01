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
    Schema::create('rooms', function (Blueprint $table) {
      $table->id();
      $table->string('room_name');
      $table->bigInteger('price');
      $table->string('room_category');
      $table->string('room_features');
      $table->string('room_facilities');
      $table->Integer('adult');
      $table->Integer('children')->nullable();
      $table->LongText('description');
      $table->mediumText('image');
      $table
        ->string('status')
        ->nullable()
        ->default('avialable');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('rooms');
  }
};
