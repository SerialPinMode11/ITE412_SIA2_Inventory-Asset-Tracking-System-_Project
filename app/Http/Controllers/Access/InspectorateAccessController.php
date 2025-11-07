<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\InspectionReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
// FIX: ADD THIS USE STATEMENT
use Illuminate\Support\Facades\Log;

class InspectorateAccessController extends Controller
{
    /**
     * Show the list of Pending Deliveries/POs requiring Inspection.
     */
    public function index()
    {
        // Get POs that have a delivery status of 'Scheduled' or 'Delivered'
        // AND do NOT have a linked InspectionReport yet.
        $pendingInspections = PurchaseOrder::with(['supplier'])
            ->whereIn('delivery_status', ['Scheduled', 'Delivered'])
            ->whereDoesntHave('inspectionReports') // Assuming a relationship where multiple items from a PO can be inspected
            ->orderBy('delivery_schedule', 'asc')
            ->paginate(10);

        return view('access.inspectorate-pending', compact('pendingInspections'));
    }

    /**
     * Show the Inspection Form for a specific Purchase Order.
     */
    public function createReport(PurchaseOrder $purchaseOrder)
    {
        // Inspection status options for the form
        $results = ['Passed', 'Failed', 'Conditional'];
        
        return view('access.inspectorate-form', compact('purchaseOrder', 'results'));
    }

    /**
     * Store the Digital Inspection Report.
     */
    public function storeReport(Request $request, PurchaseOrder $purchaseOrder)
    {
        // Validation for the Inspection Report
        $data = $request->validate([
            'report_number' => 'required|string|max:50|unique:inspection_reports,report_number',
            'inspection_date' => 'required|date',
            'result' => 'required|in:Passed,Failed,Conditional',
            'remarks' => 'nullable|string',
        ]);
        
        // Add the PO ID to the data to link the report (even if imperfectly linked)
        // In a real system, you'd link this via a pivot or detailed line-item table.
        $data['purchase_order_id'] = $purchaseOrder->id;
        
        try {
            DB::beginTransaction();
            
            // 1. Create the Inspection Report
            $report = InspectionReport::create($data);

            // 2. Update the PO's delivery status to indicate inspection is complete
            // NOTE: This logic assumes a 1:1 inspection. If multiple items per PO, this is too simple.
            if ($data['result'] == 'Passed' || $data['result'] == 'Conditional') {
                $purchaseOrder->delivery_status = 'Inspected - Ready for Stocking';
            } else {
                 $purchaseOrder->delivery_status = 'Inspection Failed - Action Required';
            }
            $purchaseOrder->save();
            
            DB::commit();

            return redirect()->route('access.inspectorate.index')->with('success', 
                "✅ Inspection Report #{$report->report_number} submitted successfully for PO: {$purchaseOrder->po_number}.");

        } catch (QueryException $e) {
            DB::rollBack();
            // FIX APPLIED: Using Log::error now that the facade is imported
            Log::error('Inspection Report DB Error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', '❌ A database error occurred while submitting the report. Please check the Report Number for uniqueness.');
        }
    }
}