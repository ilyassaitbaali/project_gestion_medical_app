<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCreneauxTable extends Migration
{
    public function up()
    {
        Schema::create('creneaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('date_heure');
            $table->integer('duree'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('creneaux');
    }
}