<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->string('name')->comment('顾客姓名');
            $table->string('description')->comment('备注')->nullable();
            $table->string('project_name')->comment('项目姓名');
            $table->dateTime('begin_time')->comment('开始时间');
            $table->dateTime('end_time')->comment('结束时间');
            $table->unsignedInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on(config('admin.database.users_table'))->onDelete('cascade');
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
        Schema::dropIfExists('reservations');
    }
}
