<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id('id');
            $table->string('site_name')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_author')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('address', 1000)->nullable();
            $table->mediumText('description')->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('email')->nullable();
            $table->string('facebook', 1000)->nullable();
            $table->string('instagram', 1000)->nullable();
            $table->string('twitter', 1000)->nullable();
            $table->string('youtube', 1000)->nullable();
            $table->string('google_plus', 1000)->nullable();
            $table->string('api_key', 1000)->nullable();
            $table->string('api_secret', 1000)->nullable();
            $table->string('zoom_email', 1000)->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
