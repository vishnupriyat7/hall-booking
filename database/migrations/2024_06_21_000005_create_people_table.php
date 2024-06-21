<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('gender');
            $table->date('dob')->nullable();
            $table->integer('age')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('id_detail')->nullable();
            $table->longText('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('post_office')->nullable();
            $table->string('pincode')->nullable();
            $table->timestamps();
        });
    }
}
