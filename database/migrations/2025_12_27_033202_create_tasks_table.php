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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('description');
            $table->unsignedTinyInteger('priority_level');
            $table->unsignedTinyInteger('status');
            $table->dateTimeTz('due_date')->nullable();
            $table->timestamps();

            //Assuming a task belongs to only one 1 project
            $table->foreignId('project_id')
                ->constrained('projects')
                ->cascadeOnDelete();

            //Assuming a task can be unassigned
            $table->foreignId('assignee_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            //Assuming a task must persist even if the creator doesn't exist in the system anymore, set creator to null
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->index('project_id');
            $table->index(['status', 'priority_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
