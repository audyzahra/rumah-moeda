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
        Schema::create('settings', function (Blueprint $table) {

            // Primary Key
            $table->id();

            // Informasi Website
            $table->string('website_name', 100);
            $table->string('website_logo', 255);
            $table->text('website_description');

            // Kontak
            $table->string('phone_number', 20);
            $table->string('email', 100);
            $table->string('fax_number', 20)->nullable();
            $table->text('address');

            // Media Sosial
            $table->string('instagram_url', 255);
            $table->string('facebook_url', 255)->nullable();
            $table->string('tiktok_url', 255)->nullable();

            // Timestamp Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
