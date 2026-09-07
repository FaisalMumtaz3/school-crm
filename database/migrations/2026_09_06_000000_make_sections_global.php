<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropUnique(['class_id', 'name']);
            $table->dropColumn('class_id');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->foreignId('class_id')->nullable()->constrained('classes')->cascadeOnDelete();
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->unique(['class_id', 'name']);
        });
    }
};
