<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdTypesTable extends Migration
{
    public function up()
    {
        Schema::create('id_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->integer('min_length')->nullable();
            $table->integer('max_length')->nullable();
            $table->string('regex')->nullable();
            $table->string('name_mal')->nullable();
            $table->timestamps();
        });
    }
}
