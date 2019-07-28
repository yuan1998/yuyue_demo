<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStatusTimeType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scheduling_statuses', function (Blueprint $table) {
            $table->string('begin_time')->nullable()->change();
            $table->string('end_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scheduling_statuses', function (Blueprint $table) {
            $table->dateTime('begin_time')->change();
            $table->dateTime('end_time')->change();
        });
    }
}
