<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('stamp_date')->default(now());;
            $table->string('action')->nullable();
            $table->time('start_time')->nullable(); // 勤務開始時刻
            $table->time('end_time')->nullable(); // 勤務終了時刻
            $table->time('break_start_time')->nullable(); // 休憩開始時刻
            $table->time('break_end_time')->nullable(); // 休憩終了時刻
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
        Schema::dropIfExists('attendances');
    }
}
