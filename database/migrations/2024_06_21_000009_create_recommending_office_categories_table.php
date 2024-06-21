<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendingOfficeCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('recommending_office_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
