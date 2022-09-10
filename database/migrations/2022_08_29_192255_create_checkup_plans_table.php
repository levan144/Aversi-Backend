<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckupPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkup_plans', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('gender');
            $table->integer('start_age')->nullable();
            $table->integer('final_age')->nullable();
            $table->json('features');
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
        Schema::dropIfExists('checkup_plans');
    }
}
