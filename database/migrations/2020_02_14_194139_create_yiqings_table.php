<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYiqingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yiqings', function (Blueprint $table) {
            $table->string('id');
            $table->string('name');
            $table->string('isSelf')->nullable();
            $table->string('relation')->nullable();
            $table->string('idCard');
            $table->string('mobile');
            $table->string('areas')->nullable();
            $table->string('beforeLocat')->nullable();
            $table->string('beforeLocatAddr')->nullable();
            $table->string('nowLocat')->nullable();
            $table->string('nowLocatAddr')->nullable();
            $table->string('carNum')->nullable();
            $table->string('companyName')->nullable();
            $table->string('fromWhere')->nullable();
            $table->string('arrivalTime')->nullable();
            $table->string('isToHubei')->nullable();
            $table->string('isContactHb')->nullable();
            $table->string('isContactFy')->nullable();
            $table->string('trafficType')->nullable();
            $table->string('isFever')->nullable();
            $table->string('feverDegree')->nullable();
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
        Schema::dropIfExists('yiqings');
    }
}
