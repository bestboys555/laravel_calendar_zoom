<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploadfile', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('name_thumb')->nullable();
            $table->string('folder');
            $table->text('file_url')->nullable();
            $table->string('file_extension');
            $table->string('tmp_key')->nullable();
            $table->bigInteger('users_id')->unsigned();
            $table->timestamps();
            $table->foreign('users_id')->references('id')->on('users');
        });

        Schema::create('uploadfile_has_table', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('uploadfile_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('table_name')->nullable();
            $table->integer('ref_table_id')->nullable();
            $table->enum('is_cover', ['0', '1'])->default('0');
            $table->integer('section_order')->nullable();
            $table->timestamps();
            $table->foreign('uploadfile_id')->references('id')->on('uploadfile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploadfile');
        Schema::dropIfExists('uploadfile_has_table');
    }
}
