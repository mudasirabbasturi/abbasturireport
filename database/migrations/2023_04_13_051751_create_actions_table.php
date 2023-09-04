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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->required();
            $table->integer('user_id')->required();
            $table->text('project_marking')->nullable();
            $table->text('marking_percent')->nullable();
            $table->text('project_excel')->nullable();
            $table->text('excel_percent')->nullable();
            $table->text('project_pricing')->nullable();
            $table->text('pricing_percent')->nullable();
            $table->text('project_quality_assurance')->nullable();
            $table->text('assurance_percent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
