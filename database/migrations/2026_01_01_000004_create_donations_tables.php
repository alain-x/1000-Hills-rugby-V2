<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('RWF');
            $table->decimal('original_amount', 12, 2)->nullable();
            $table->string('original_currency', 3)->nullable();
            $table->decimal('fx_rate_to_rwf', 10, 2)->default(1);
            $table->string('purpose')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('PENDING');
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('confirmation_code')->nullable();
            $table->string('order_tracking_id')->nullable()->index();
            $table->text('redirect_url')->nullable();
            $table->json('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('donations');
    }
};
