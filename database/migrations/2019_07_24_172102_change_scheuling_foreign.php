<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeScheulingForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedulings', function (Blueprint $table) {
            $table->unsignedBigInteger('scheduling_status_id');
            $table->foreign('scheduling_status_id')->references('id')->on('scheduling_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedulings', function (Blueprint $table) {
            $table->dropForeign(['scheduling_status_id']);
            $table->dropColumn('scheduling_status_id');
        });
    }
}
