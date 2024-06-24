<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToGroupPeopleTable extends Migration
{
    public function up()
    {
        Schema::table('group_people', function (Blueprint $table) {
            $table->unsignedBigInteger('gallery_pass_id')->nullable();
            $table->foreign('gallery_pass_id', 'gallery_pass_fk_9894167')->references('id')->on('gallery_passes');
        });
    }
}
