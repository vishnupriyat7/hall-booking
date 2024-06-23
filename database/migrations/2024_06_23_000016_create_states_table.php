<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('state_abbr')->nullable();
            $table->string('state_name')->nullable();
            $table->string('default_state')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
