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
            $table->integer('age');
            $table->string('mobile');
            $table->string('id_detail')->nullable();
            $table->longText('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode');
            $table->string('purpose');
            $table->date('date_of_visit')->nullable();
            $table->string('district')->nullable();
            $table->string('post_office')->nullable();
            $table->string('visiting_office')->nullable();
            $table->timestamps();
        });
    }
}
