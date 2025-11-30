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
        Schema::create('inspection_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number', 50)->unique();
            $table->date('inspection_date');
            $table->enum('result', ['Passed', 'Failed', 'Conditional']);

            // ADDED FOREIGN KEY: Link report back to the Purchase Order
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_orders')->onDelete('set null');
            
            $table->text('remarks')->nullable(); // Add remarks column
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_reports');
    }
};
