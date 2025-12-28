<?php

use App\Enums\Models\Project\ProjectVisibility;
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
            $table->string('title')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedTinyInteger('status');
            $table->mediumText('description');
            $table->unsignedTinyInteger('visibility')->default(ProjectVisibility::PUBLIC->value);
            $table->softDeletes();

            //Assuming a project can only have 1 PM
            $table->foreignId('project_manager_id')
                ->nullable()
                ->constrained('organization_users')
                ->cascadeOnDelete();

            //Assuming a project belongs to only one 1 organization
            $table->foreignId('organization_id')
                ->constrained('organizations')
                ->cascadeOnDelete();

            $table->integer('associated_task_count')->default(0);
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
