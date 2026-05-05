<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('result_date')->nullable();
            $table->date('last_date')->nullable();
            $table->string('registration_link')->nullable();
            $table->text('event_selection_category')->nullable();
            $table->text('participation_category')->nullable();
            $table->string('winner_certificate')->nullable();
            $table->string('participation_certificate')->nullable();
            $table->string('audience_certificate')->nullable();
            $table->text('cert_layout')->nullable();
            $table->boolean('is_participation_cert_allow')->default(false);
            $table->boolean('is_auto_gen_certificate')->default(false);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void {
        Schema::dropIfExists('competitions');
    }
};