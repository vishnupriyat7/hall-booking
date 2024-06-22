<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostOfficeDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('post_office_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pincode')->nullable();
            $table->string('epost_delivery_status')->nullable();
            $table->string('default_post_flag')->nullable();
            $table->string('post_office_name')->nullable();
            $table->string('post_office_status')->nullable();
            $table->string('district_name')->nullable();
            $table->string('postal_circle')->nullable();
            $table->timestamps();
        });
    }
}
