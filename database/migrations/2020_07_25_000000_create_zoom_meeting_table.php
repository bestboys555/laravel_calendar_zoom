<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZoomMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoom_meeting', function (Blueprint $table) {
            $table->string('meeting_type');
            $table->bigInteger('meeting_id')->unsigned();
            $table->index(['meeting_type', 'meeting_id'], 'model_has_zoom_meeting_model_id_meeting_type_index');
            $table->string('zoom_id');
            $table->string('password');
            $table->dateTime('start_time');
            $table->integer('duration');
            $table->string('timezone');
            $table->longText('start_url');
            $table->string('join_url');
            $table->longText('ref_text')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->primary(['meeting_id', 'meeting_type'], 'model_has_zoom_meeting_meeting_type_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zoom_meeting');
    }
}
