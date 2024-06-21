<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLockersTable extends Migration
{
    public function up()
    {
        Schema::table('lockers', function (Blueprint $table) {
            $table->unsignedBigInteger('pass_id')->nullable();
            $table->foreign('pass_id', 'pass_fk_9884865')->references('id')->on('gallery_passes');
        });
    }
}
