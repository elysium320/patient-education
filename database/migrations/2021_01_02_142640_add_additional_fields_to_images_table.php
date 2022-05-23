<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('filename')->nullable();
            $table->string('original_src')->nullable();
            $table->string('entity_type')->nullable();
            $table->integer('entity_id')->nullable();
            $table->string('encoded_src')->nullable();
            $table->string('alt_attribute')->nullable();
            $table->string('extension', 5)->nullable();
            $table->integer('order')->unsigned()->nullable();
            $table->tinyInteger('primary')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            //
        });
    }
}
