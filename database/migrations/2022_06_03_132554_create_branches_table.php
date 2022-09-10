<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('type')->default('clinic');
            $table->json('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            // $table->json('city')->nullable();
            $table->json('address')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->json('working_time')->nullable();
            $table->json('services')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('branches');
    }
}
