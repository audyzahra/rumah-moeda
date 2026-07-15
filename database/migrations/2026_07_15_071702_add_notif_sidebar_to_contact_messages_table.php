<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {

            $table->boolean('notif_sidebar')
                  ->default(0)
                  ->after('is_read');

        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {

            $table->dropColumn('notif_sidebar');

        });
    }
};
