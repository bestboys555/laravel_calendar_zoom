<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursecalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursecalendar', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->enum('type_calendar', ['Course', 'Meeting'])->default('Course');
            $table->text('location')->nullable();
            $table->text('target_audience')->nullable();
            $table->text('course_director')->nullable();
            $table->integer('number_participants')->nullable();
            $table->double('price')->default('0')->nullable();
            $table->longText('detail')->nullable();
            $table->longText('faqs')->nullable();
            $table->longText('accommodation')->nullable();
            $table->longText('payment_detail')->nullable();
            $table->dateTime('register_start_date')->nullable();
            $table->dateTime('register_end_date')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('open_register')->default('0');
            $table->boolean('show_index')->default('0');
            $table->boolean('open_zoom')->default('0');
            $table->timestamps();
        });

        Schema::create('coursecalendar_register', function (Blueprint $table) {
            $table->id('id');
            $table->string('tell');
            $table->longText('address')->nullable();
            $table->bigInteger('coursecalendar_id')->unsigned();
            $table->bigInteger('users_id')->unsigned();
            $table->string('file_payment')->nullable();
            $table->text('note')->nullable();
            $table->boolean('confirm_meeting')->nullable()->default('0');
            $table->timestamps();
            $table->foreign('coursecalendar_id')->references('id')->on('coursecalendar');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coursecalendar');
        Schema::dropIfExists('meeting_register');
    }
}
