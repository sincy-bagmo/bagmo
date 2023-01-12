<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodBagLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_bag_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refrigerator_id')->constrained('refrigerators');
            $table->foreignId('storage_rack_id')->constrained('storage_racks');
            $table->foreignId('blood_bag_id')->constrained('blood_bags');
            $table->dateTime('scan_in')->nullable();
            $table->foreignId('scan_in_user')->nullable()->constrained('users');
            $table->dateTime('scan_out')->nullable();
            $table->foreignId('scan_out_user')->nullable()->constrained('users');
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
        Schema::dropIfExists('blood_bag_logs');
    }
}
