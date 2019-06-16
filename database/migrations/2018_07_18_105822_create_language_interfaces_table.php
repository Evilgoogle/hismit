<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageInterfacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_interfaces', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lang_id')->nullable();
            $table->text('key')->nullable();
            $table->text('name')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();
            $table->foreign('lang_id')->references('id')->on('languages')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_interfaces');
    }
}
