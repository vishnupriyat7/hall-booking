<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSelfRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::table('self_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('id_type_id')->nullable();
            $table->foreign('id_type_id', 'id_type_fk_9869039')->references('id')->on('id_types');
            $table->unsignedBigInteger('visiting_office_category_id')->nullable();
            $table->foreign('visiting_office_category_id', 'visiting_office_category_fk_9869048')->references('id')->on('visiting_office_categories');
            $table->unsignedBigInteger('visiting_office_id')->nullable();
            $table->foreign('visiting_office_id', 'visiting_office_fk_9869049')->references('id')->on('visiting_offices');
        });
    }
}
