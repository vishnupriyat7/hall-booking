<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPostOfficeDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('post_office_details', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->nullable();
            $table->foreign('state_id', 'state_fk_9884907')->references('id')->on('states');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id', 'district_fk_9884908')->references('id')->on('districts');
        });
    }
}
