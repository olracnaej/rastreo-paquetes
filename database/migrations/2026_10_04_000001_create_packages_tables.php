<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id', 60)->unique();
            $table->string('customer_name', 120)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('status', 60);
            $table->string('location', 120)->nullable();
            $table->date('estimated_delivery')->nullable();
            $table->timestamps();
        });

        Schema::create('package_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('status', 60);
            $table->string('location', 120)->nullable();
            $table->string('note', 255)->nullable();
            $table->timestamps();
            $table->index(['package_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_events');
        Schema::dropIfExists('packages');
    }
};
