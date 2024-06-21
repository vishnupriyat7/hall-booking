<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToGalleryPassesTable extends Migration
{
    public function up()
    {
        Schema::table('gallery_passes', function (Blueprint $table) {
            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreign('person_id', 'person_fk_9874832')->references('id')->on('people');
            $table->unsignedBigInteger('guide_id')->nullable();
            $table->foreign('guide_id', 'guide_fk_9884863')->references('id')->on('guiding_officers');
        });
    }
}
