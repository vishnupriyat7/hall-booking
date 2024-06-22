<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLockerItemsTable extends Migration
{
    public function up()
    {
        Schema::table('locker_items', function (Blueprint $table) {
            $table->unsignedBigInteger('locker_id')->nullable();
            $table->foreign('locker_id', 'locker_fk_9884876')->references('id')->on('lockers');
        });
    }
}
