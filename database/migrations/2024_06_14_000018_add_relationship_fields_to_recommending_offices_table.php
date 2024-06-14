<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRecommendingOfficesTable extends Migration
{
    public function up()
    {
        Schema::table('recommending_offices', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_9868896')->references('id')->on('recommending_office_categories');
        });
    }
}
