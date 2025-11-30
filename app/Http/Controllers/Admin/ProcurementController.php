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
            ->whereHas('purchaseOrder', function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('final_disposition')
                        ->orWhereNotIn('final_disposition', ['Transferred_to_Head', 'Disposed']);
                });
            })
            ->whereIn('result', ['Passed', 'Conditional'])

            ->orderBy('inspection_date', 'asc')
            ->paginate(10);

        return view('admin.procurement.index', compact('inspectionReports'));
    }

    // Admin action: Accept/Stock the PO items and mark for Supply Head review
    public function acceptStock(InspectionReport $report)
    {
        $purchaseOrder = $report->purchaseOrder;

        if (!$purchaseOrder) {
            return redirect()->back()->with('error', '❌ Error: No Purchase Order linked to this Inspection Report (ID: ' . $report->id . ').');
        }

        try {
            DB::beginTransaction();

            $purchaseOrder->delivery_status = 'Delivered'; // Use valid enum value
            $purchaseOrder->final_disposition = 'Transferred_to_Head';
            $purchaseOrder->save();

            $asset = PhysicalAsset::create([
                'asset_tag' => 'PO-' . $purchaseOrder->po_number,
                'item_name' => $purchaseOrder->notes ?? 'Items from PO: ' . $purchaseOrder->po_number,
                'category_id' => 1,
                'date_acquired' => now(),
                'acquisition_cost' => $purchaseOrder->total_amount,
                'condition' => 'New',
                'status' => 'In Storage',
                'supplier_id' => $purchaseOrder->supplier_id,
                'inspection_report_id' => $report->id,
                'remarks' => 'Auto-generated from PO acceptance. Initial cost: ' . $purchaseOrder->total_amount,
            ]);

            DB::commit();

            return redirect()->route('admin.procurement.index')->with(
                'success',
                "✅ Report #{$report->report_number} accepted and SENT TO SUPPLY HEAD. Asset Tag: {$asset->asset_tag}"
            );
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Procurement Stocking Error: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ System Error: ' . $e->getMessage());
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

            return redirect()->route('admin.procurement.index')->with(
                'success',
                "❌ Report #{$report->report_number} for PO {$purchaseOrder->po_number} marked as Disposed/Rejected. Item not added to inventory."
            );
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Procurement Disposition Error: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ System Error: Could not finalize disposition.');
        }
    }
}
