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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->text('project_title')->nullable();
            $table->text('project_address')->nullable();
            $table->text('project_pricing')->nullable();
            $table->text('project_area')->nullable();
            $table->text('project_commercial_residential')->nullable();
            $table->text('project_line_items_pricing')->nullable();
            $table->text('project_floor_number')->nullable();
            $table->text('project_main_scope')->nullable();
            $table->text('project_scope_details')->nullable();
            $table->text('project_template')->nullable();
            $table->text('project_onside_link')->nullable();
            $table->text('project_ofside_link')->nullable();
            $table->date('project_due_date')->nullable();
            $table->text('project_steps')->nullable();
            $table->text('project_notes')->nullable();
            $table->text('project_budget')->nullable();
            $table->text('project_deduction')->nullable();
            $table->text('project_total_price')->nullable();
            $table->text('project_status')->default('pending');
            $table->text('project_final_status')->default('none');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
