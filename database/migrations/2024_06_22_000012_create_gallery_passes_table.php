<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryPassesTable extends Migration
{
    public function up()
    {
        Schema::create('gallery_passes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number');
            $table->date('issued_date')->nullable();
            $table->date('date_of_visit')->nullable();
            $table->integer('print_count')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_detail')->nullable();
            $table->longText('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('post_office')->nullable();
            $table->string('pincode')->nullable();
            $table->string('photo')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->integer('age')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }
}
