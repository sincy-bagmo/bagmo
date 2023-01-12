<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageRacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_racks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refrigerator_id')->constrained('refrigerators');
            $table->string('rack_name')->nullable();
            $table->string('rack_number')->nullable();
            $table->string('rack_barcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_racks');
    }
}
