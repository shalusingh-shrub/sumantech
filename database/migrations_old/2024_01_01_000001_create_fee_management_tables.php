<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "Monthly Fee", "Admission Fee"
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('fee_category_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'partial', 'overdue'])->default('pending');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->string('payment_method')->nullable(); // cash, online, UPI
            $table->string('transaction_id')->nullable();
            $table->string('receipt_number')->nullable()->unique();
            $table->text('remarks')->nullable();
            $table->foreignId('collected_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fees');
        Schema::dropIfExists('fee_categories');
    }
};
