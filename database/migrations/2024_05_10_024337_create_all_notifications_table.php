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
        Schema::create('all_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('info');
            $table->text('message');
            $table->unsignedInteger('related_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_notifications');
    }
};
