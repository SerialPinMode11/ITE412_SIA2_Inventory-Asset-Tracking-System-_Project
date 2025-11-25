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
        Schema::create('asset_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The Requisitioner
            $table->foreignId('category_id')->nullable()->constrained('asset_categories')->onDelete('set null'); // Optional for filtering
            
            $table->string('item_description', 255);
            $table->unsignedInteger('quantity');
            $table->string('reason', 500);
            
            $table->enum('priority', ['Low', 'Medium', 'High', 'Urgent'])->default('Medium');
            
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Fulfilled'])->default('Pending');
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users')->onDelete('set null'); // The Admin/Supply Officer
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_requests');
    }
};
