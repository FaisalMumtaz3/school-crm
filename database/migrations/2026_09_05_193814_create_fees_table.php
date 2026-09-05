<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('month');

            $table->unsignedSmallInteger('year');

            $table->decimal('fee_amount', 10, 2)->default(0);

            $table->decimal('paid_amount', 10, 2)->default(0);

            $table->decimal('balance', 10, 2)->default(0);

            $table->enum('status', [
                'paid',
                'partial',
                'unpaid',
            ])->default('unpaid');

            $table->date('due_date')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            /*
             * One monthly fee record per student.
             */
            $table->unique([
                'student_id',
                'month',
                'year'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};