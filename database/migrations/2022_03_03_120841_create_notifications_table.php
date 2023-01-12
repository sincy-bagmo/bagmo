<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->bigInteger('sender_id');
            $table->tinyInteger('sender_type')->comment('0 => CSSD User / Admin | 1 => OT User | 2 => Washing User | 3 => Sterilisation user | 4 => Packing user');
            $table->bigInteger('receiver_id');
            $table->tinyInteger('receiver_type')->comment('0 => CSSD User / Admin | 1 => OT User | 2 => Washing User | 3 => Sterilisation user | 4 => Packing user');
            $table->string('post_url')->nullable();
            $table->tinyInteger('seen')->comment('0 => not seen | 1 => Seen');
            $table->softDeletes();
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
        Schema::dropIfExists('notifications');
    }
}
