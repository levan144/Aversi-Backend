<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('type')->default('photo');
            $table->json('photo')->nullable();
            $table->json('video')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('gallery');
    }
}
