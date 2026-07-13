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
        Schema::table('organization_structures', function (Blueprint $table) {

            $table->unsignedBigInteger('parent_id')
                ->nullable()
                ->after('id');

            $table->foreign('parent_id')
                ->references('id')
                ->on('organization_structures')
                ->nullOnDelete();

            $table->dropColumn('display_order');
        });
    }

    public function down(): void
    {
        Schema::table('organization_structures', function (Blueprint $table) {

            $table->integer('display_order')->default(0);

            $table->dropForeign(['parent_id']);

            $table->dropColumn('parent_id');
        });
    }
};
