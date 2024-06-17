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
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
