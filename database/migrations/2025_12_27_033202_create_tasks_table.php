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

            //Assuming a task can be unassigned
            $table->foreignId('assignee')
                ->nullable()
                ->constrained('organization_users')
                ->nullOnDelete();

            //Assuming a task must persist even if the creator doesn't exist in the system anymore, set creator to null
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('organization_users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('organization_users')
                ->nullOnDelete();
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
