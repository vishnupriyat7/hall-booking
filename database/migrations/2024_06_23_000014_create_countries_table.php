<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country_abbr');
            $table->string('country_name');
            $table->string('iso_3')->nullable();
            $table->string('numcode')->nullable();
            $table->string('default_country')->nullable();
            $table->string('iso')->nullable();
            $table->string('phonecode')->nullable();
            $table->timestamps();
        });
    }
}
