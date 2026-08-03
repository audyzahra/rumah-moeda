<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_views', function (Blueprint $table) {

            $table->id();

            $table->foreignId('news_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('ip_address',45);

            $table->text('user_agent')->nullable();

            $table->timestamps();

            $table->unique([
                'news_id',
                'ip_address'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_views');
    }
};
