<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorPassesTable extends Migration
{
    public function up()
    {
        Schema::create('visitor_passes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number');
            $table->datetime('pass_valid_from')->nullable();
            $table->datetime('pass_valid_upto')->nullable();
            $table->date('issued_date')->nullable();
            $table->date('date_of_visit')->nullable();
            $table->string('purpose');
            $table->string('visiting_office')->nullable();
            $table->string('recommending_office')->nullable();
            $table->string('mobile')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_detail')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('post_office')->nullable();
            $table->string('pincode')->nullable();
            $table->integer('print_count')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('camera_allowed')->default(0)->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->integer('age')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
