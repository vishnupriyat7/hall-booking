<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLockerItemsTable extends Migration
{
    public function up()
    {
        Schema::create('locker_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_name')->nullable();
            $table->integer('item_count')->nullable();
            $table->timestamps();
        });
    }
}
