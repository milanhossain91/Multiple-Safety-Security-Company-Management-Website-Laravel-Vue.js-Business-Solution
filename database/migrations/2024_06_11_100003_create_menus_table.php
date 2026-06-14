<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menu groups / locations (header, footer, sidebar...).
     * Items belonging to a menu live in tbl_menu_item.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Main Header Menu", "Footer Menu"
            $table->string('location')->unique(); // header | footer | sidebar
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('tbl_menu');
    }
};
