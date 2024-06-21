<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLockerTokensTable extends Migration
{
    public function up()
    {
        Schema::create('locker_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token')->nullable();
            $table->boolean('enabled')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
