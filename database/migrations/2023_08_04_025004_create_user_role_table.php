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
        Schema::create('role_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
//            $table->unsignedSmallInteger('number_of_nights')->virtualAs('greatest(0, number_of_days - 1)');
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('role_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role');
    }
};
