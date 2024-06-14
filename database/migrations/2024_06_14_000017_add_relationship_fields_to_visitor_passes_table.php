<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVisitorPassesTable extends Migration
{
    public function up()
    {
        Schema::table('visitor_passes', function (Blueprint $table) {
            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreign('person_id', 'person_fk_9868790')->references('id')->on('people');
        });
    }
}
