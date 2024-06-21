<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDistrictsTable extends Migration
{
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->unsignedBigInteger('state_cd_id')->nullable();
            $table->foreign('state_cd_id', 'state_cd_fk_9884894')->references('id')->on('states');
        });
    }
}
