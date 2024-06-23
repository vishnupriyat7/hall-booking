<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('district_abbr')->nullable();
            $table->string('district_name')->nullable();
            $table->string('pin_code')->nullable();
            $table->timestamps();
        });
    }
}
