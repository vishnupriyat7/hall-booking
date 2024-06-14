<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPeopleTable extends Migration
{
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->unsignedBigInteger('id_type_id')->nullable();
            $table->foreign('id_type_id', 'id_type_fk_9868788')->references('id')->on('id_types');
        });
    }
}
