<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Page builder blocks. Each row is one drag-and-drop section of a page.
     * The "settings" JSON column stores per-block builder options
     * (columns, background colour, button links, etc.) so the admin can
     * compose pages without touching code or the frontend design.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_page_block', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('block_type')->default('text'); // text | image | hero | gallery | cards | html | video | cta
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->json('settings')->nullable(); // builder config (cols, bg, alignment, links...)
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('tbl_page')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_page_block');
    }
};
