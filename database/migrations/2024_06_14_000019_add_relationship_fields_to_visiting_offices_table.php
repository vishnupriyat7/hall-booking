<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVisitingOfficesTable extends Migration
{
    public function up()
    {
        Schema::table('visiting_offices', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_9868912')->references('id')->on('visiting_office_categories');
        });
    }
}
