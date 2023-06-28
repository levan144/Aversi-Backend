<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckupPlanCheckupServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkup_plan_checkup_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkup_plan_id');
            $table->unsignedBigInteger('checkup_service_id');
            $table->foreign('checkup_plan_id')->references('id')->on('checkup_plans')->onDelete('cascade');
            $table->foreign('checkup_service_id')->references('id')->on('checkup_services')->onDelete('cascade');
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
        Schema::dropIfExists('checkup_plan_checkup_service');
    }
}
