<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodBagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_bags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refrigerator_id')->constrained('refrigerators');
            $table->foreignId('storage_rack_id')->constrained('storage_racks');
            $table->string('blood_bag_name')->nullable();
            $table->tinyInteger('type')->nullable()->comment('1 => Prc, 2 => Ffp, 3 => Pc');
            $table->string('blood_group')->nullable();
            $table->string('product_id')->nullable();
            $table->string('volume', 50)->nullable();
            $table->date('expiry_date')->nullable();
            $table->tinyInteger('status')->nullable()->comment('0 => Out, 1 => In' );
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
        Schema::dropIfExists('blood_bags');
    }
}
