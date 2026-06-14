<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tbl_page', function (Blueprint $table) {
            // Visual page-builder data: ordered list of schema-driven blocks (JSON).
            // NOTE: the existing string `template` column stays (it is the layout: default/fullwidth/landing).
            $table->json('template_data')->nullable()->after('template');
        });
    }

    public function down()
    {
        Schema::table('tbl_page', function (Blueprint $table) {
            $table->dropColumn('template_data');
        });
    }
};
