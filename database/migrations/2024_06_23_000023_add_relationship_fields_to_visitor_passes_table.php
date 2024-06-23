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
            $table->unsignedBigInteger('visiting_office_category_id')->nullable();
            $table->foreign('visiting_office_category_id', 'visiting_office_category_fk_9871046')->references('id')->on('visiting_office_categories');
            $table->unsignedBigInteger('recommending_office_category_id')->nullable();
            $table->foreign('recommending_office_category_id', 'recommending_office_category_fk_9871047')->references('id')->on('recommending_office_categories');
        });
    }
}
