<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cover');
            $table->string('title');
            $table->longText('content');
            $table->longText('papers')->nullable();
            $table->integer('region_id');
            $table->integer('province_id');
            $table->integer('district_id');
            $table->integer('user_id');
            $table->string('address');
            $table->string('acreage');
            $table->string('price');
            $table->integer('views')->default(0);
            $table->string('map')->nullable();
            $table->integer('status')->default(1);
            $table->string('characteristics')->nullable();
            $table->integer('room_number')->default(1);
            $table->integer('direction_id')->default(1);
            $table->text('format');
            $table->softDeletes();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
