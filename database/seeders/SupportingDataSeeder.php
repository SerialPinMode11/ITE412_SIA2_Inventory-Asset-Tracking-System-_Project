<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupportingDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Asset Categories
        DB::table('asset_categories')->insertOrIgnore([
            ['name' => 'IT Equipment', 'description' => 'Computers, Laptops, Printers'],
            ['name' => 'Furniture', 'description' => 'Desks, Chairs, Cabinets'],
            ['name' => 'Machinery', 'description' => 'Heavy equipment, tools'],
        ]);

        // 2. Suppliers
        DB::table('suppliers')->insertOrIgnore([
            ['name' => 'Tech Solutions Inc.', 'contact_person' => 'Juan Dela Cruz'],
            ['name' => 'Office Supply Co.', 'contact_person' => 'Maria Santos'],
        ]);

        // 3. Locations
        DB::table('locations')->insertOrIgnore([
            ['name' => 'Main Office - Room 101', 'building' => 'Admin Building'],
            ['name' => 'IT Lab - Room 205', 'building' => 'New Sciences Building'],
        ]);

        // 4. Employees (Custodians)
        DB::table('employees')->insertOrIgnore([
            ['name' => 'Prof. Peter Dizon', 'employee_id' => 'EMP1001', 'department' => 'IT Department'],
            ['name' => 'Ms. Sarah Reyes', 'employee_id' => 'EMP1002', 'department' => 'Accounting'],
        ]);

        // 5. Inspection Reports
        DB::table('inspection_reports')->insertOrIgnore([
            ['report_number' => 'IR-2024-001', 'inspection_date' => now()->subDays(10), 'result' => 'Passed'],
        ]);

        // 6. Payment Statuses (NEW - Corrected Logic)
        DB::table('payment_statuses')->insertOrIgnore([ 
            ['name' => 'Pending', 'color_code' => '#f97316'], 
            ['name' => 'Scheduled', 'color_code' => '#2563eb'], 
            ['name' => 'Paid', 'color_code' => '#16a34a'], 
            ['name' => 'On Hold', 'color_code' => '#dc2626'], 
        ]);
        
        // Retrieve IDs for use in Purchase Order insert
        $paidStatusId = DB::table('payment_statuses')->where('name', 'Paid')->value('id');
        $pendingStatusId = DB::table('payment_statuses')->where('name', 'Pending')->value('id');
        $supplierId = DB::table('suppliers')->where('name', 'Tech Solutions Inc.')->value('id');

        // 7. Purchase Orders (NEW)
        if ($supplierId && $paidStatusId && $pendingStatusId) {
            DB::table('purchase_orders')->insertOrIgnore([
                [
                    'po_number' => 'PO-2024-1001',
                    'supplier_id' => $supplierId,
                    'order_date' => now()->subDays(30),
                    'total_amount' => 150000.00,
                    'delivery_schedule' => now()->addDays(5),
                    'delivery_status' => 'Scheduled',
                    'payment_status_id' => $paidStatusId,
                    'notes' => '50 units of new monitors.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'po_number' => 'PO-2024-1002',
                    'supplier_id' => $supplierId,
                    'order_date' => now()->subDays(10),
                    'total_amount' => 50000.00,
                    'delivery_schedule' => now()->addDays(15),
                    'delivery_status' => 'Pending',
                    'payment_status_id' => $pendingStatusId,
                    'notes' => 'Office chairs.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
        
        $this->command->info("Supporting tables seeded successfully!");
    }
}