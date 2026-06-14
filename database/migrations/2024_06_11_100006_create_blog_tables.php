<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Blog categories
        Schema::create('tbl_post_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        // Blog posts (dynamic, shown on the frontend)
        Schema::create('tbl_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('tbl_post_category')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->string('tags')->nullable();           // comma separated
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->boolean('status')->default(1);          // 1 published, 0 draft
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_post');
        Schema::dropIfExists('tbl_post_category');
    }
};
