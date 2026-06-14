<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Global site settings, fully editable from the admin panel
     * (site name, contact info, social links, SEO defaults, scripts...).
     * Stored as grouped key/value pairs so new options need no schema change.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_setting', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general'); // general | contact | social | seo
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('type')->default('text'); // text | textarea | image | boolean | html
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_setting');
    }
};
