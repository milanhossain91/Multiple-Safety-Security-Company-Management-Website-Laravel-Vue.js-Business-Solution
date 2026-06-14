<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Nested menu items. The self-referencing "parent_id" gives unlimited
     * depth, which covers menu -> sub menu -> sub sub menu and beyond.
     * A null parent_id is a top-level (root) item.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_menu_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('parent_id')->nullable(); // self-reference for sub / sub-sub menu
            $table->string('title');
            $table->string('link_type')->default('custom'); // custom | page | category | route
            $table->string('url')->nullable();              // used when link_type = custom
            $table->unsignedBigInteger('page_id')->nullable(); // used when link_type = page
            $table->string('icon')->nullable();
            $table->string('target')->default('_self');     // _self | _blank
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('tbl_menu')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('tbl_menu_item')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('tbl_page')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_menu_item');
    }
};
