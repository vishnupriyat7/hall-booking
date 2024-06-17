<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelfRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('self_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('gender');
            $table->date('dob');
            $table->integer('age');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('id_detail');
            $table->longText('address');
            $table->string('country');
            $table->string('state');
            $table->string('district');
            $table->string('pincode');
            $table->string('post_office')->nullable();
            $table->string('purpose');
            $table->date('date_of_visit')->nullable();
            $table->string('visiting_office')->nullable();
            $table->integer('number')->nullable();
            $table->string('pass_type')->nullable();
            $table->timestamps();
        });
    }
}
