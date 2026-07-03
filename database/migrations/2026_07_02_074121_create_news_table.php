<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
        {
            Schema::create('news', function (Blueprint $table) {
                $table->id('news_id');
                $table->string('title', 100);
                $table->string('thumbnail', 100);
                $table->longText('content');

                $table->foreignId('category_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('slug', 255)->unique();
                $table->dateTime('publish_date');

                $table->foreignId('author_id')
                    ->constrained('users')
                    ->restrictOnDelete();

                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
