<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupPeopleTable extends Migration
{
    public function up()
    {
        Schema::create('group_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
