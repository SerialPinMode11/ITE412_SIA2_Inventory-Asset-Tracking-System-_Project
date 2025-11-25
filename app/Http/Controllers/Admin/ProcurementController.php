<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PhysicalAsset;
use App\Models\InspectionReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProcurementController extends Controller
{
    // List all Inspection Reports ready for final action (Supply Officer's view)
    public function index()
    {
        // Query InspectionReports that were 'Passed' or 'Conditional'
        $inspectionReports = InspectionReport::with(['purchaseOrder.supplier'])
            ->whereIn('result', ['Passed', 'Conditional'])
            
            // FIX: SIMPLIFY and RELY ON THE FINAL DISPOSITION (Admin's action).
            // A report is ready for Procurement if it Passed/Conditional AND the Admin has NOT finalized the PO.
            ->whereHas('purchaseOrder', function ($query) {
                // The item is ready for action if the final_disposition is NULL or NOT in the closed statuses.
                $query->whereNotIn('final_disposition', ['Transferred_to_Head', 'Disposed']);
            })
            
            ->orderBy('inspection_date', 'asc')
            ->paginate(10);
            
        return view('admin.procurement.index', compact('inspectionReports'));
    }

    // Admin action: Accept/Stock the PO items and mark for Supply Head review
    public function acceptStock(InspectionReport $report)
    {
        $purchaseOrder = $report->purchaseOrder; // Get the related PO
        
        try {
            DB::beginTransaction();
            
            // 1. Mark PO as Stocked/Fulfilled
            $purchaseOrder->delivery_status = 'Stocked/Fulfilled';
            
            // 2. Mark for Supply Head review (Transferred_to_Head)
            $purchaseOrder->final_disposition = 'Transferred_to_Head'; 
            $purchaseOrder->save();
            
            // 3. CREATE the Physical Asset (Simplified)
            $asset = PhysicalAsset::create([
                'asset_tag' => 'PO-' . $purchaseOrder->po_number, 
                'item_name' => $purchaseOrder->notes ?? 'Items from PO: ' . $purchaseOrder->po_number,
                'category_id' => 1, // Default Category ID (must exist!)
                'date_acquired' => now(),
                'acquisition_cost' => $purchaseOrder->total_amount,
                'condition' => 'New',
                'status' => 'In Storage',
                'supplier_id' => $purchaseOrder->supplier_id,
                'inspection_report_id' => $report->id, // Use the ID from the current report
                'remarks' => 'Auto-generated from PO acceptance. Initial cost: ' . $purchaseOrder->total_amount,
            ]);

            DB::commit();

            return redirect()->route('admin.procurement.index')->with('success', 
                "✅ Report #{$report->report_number} accepted, Stocked, and SENT TO SUPPLY HEAD. Asset Tag: {$asset->asset_tag}");

        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Procurement Stocking Error: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ System Error: Could not create the asset record. Check database logs.');
        }
    }

    // Admin action: Dispose/Cancel Failed POs
    public function disposeCancel(InspectionReport $report)
    {
        $purchaseOrder = $report->purchaseOrder; // Get the related PO
        
        try {
            DB::beginTransaction();

            $purchaseOrder->delivery_status = 'Finalized - Dispositioned';
            $purchaseOrder->final_disposition = 'Disposed'; // Mark as disposed/cancelled
            $purchaseOrder->save();
            
            DB::commit();

            return redirect()->route('admin.procurement.index')->with('success', 
                "❌ Report #{$report->report_number} for PO {$purchaseOrder->po_number} marked as Disposed/Rejected. Item not added to inventory.");

        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Procurement Disposition Error: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ System Error: Could not finalize disposition.');
        }
    }
}