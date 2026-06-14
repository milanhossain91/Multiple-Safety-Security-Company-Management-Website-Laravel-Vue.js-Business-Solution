<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Dynamic pages fully controlled from the admin panel.
     * Each page is rendered through the page builder (tbl_page_block).
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_page', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('template')->default('default'); // default | fullwidth | landing
            $table->string('banner_image')->nullable();

            // SEO fields (admin controlled)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->boolean('show_in_menu')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(1); // 1 = published, 0 = draft
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
        Schema::dropIfExists('tbl_page');
    }
};
