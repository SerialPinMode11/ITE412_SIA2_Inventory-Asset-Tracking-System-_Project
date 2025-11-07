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
        Schema::create('physical_assets', function (Blueprint $table) {
            $table->id();
             $table->string('asset_tag', 50)->unique(); // Unique property/asset number
            $table->string('item_name', 150);
            
            // Foreign Keys
            $table->foreignId('category_id')->constrained('asset_categories')->onDelete('restrict');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('custodian_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->foreignId('inspection_report_id')->nullable()->constrained('inspection_reports')->onDelete('set null');

            $table->string('model', 100)->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->date('date_acquired');
            $table->decimal('acquisition_cost', 12, 2)->default(0.00);
            
            $table->enum('condition', ['New', 'Good', 'Fair', 'Needs Repair', 'Disposed'])->default('New');
            $table->enum('status', ['In Storage', 'Issued', 'Under Maintenance', 'Disposed', 'Lost'])->default('In Storage');
            
            $table->date('warranty_expiry')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_assets');
    }
};
