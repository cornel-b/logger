<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_logs', function (Blueprint $table) {
            $table->id();
            $table->text('stack_trace');
            $table->string('verbosity_level');
            $table->string('route_name')->nullable();
            $table->string('route_url');
            $table->string('route_path');
            $table->string('route_method');
            $table->json('route_params')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('db_connections');
            $table->timestamps();
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_logs');
    }
};
