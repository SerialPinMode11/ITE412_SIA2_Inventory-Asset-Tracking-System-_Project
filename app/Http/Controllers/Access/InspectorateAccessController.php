<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\InspectionReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException; // ADD THIS
use Illuminate\Support\Facades\Log;

class InspectorateAccessController extends Controller
{
    // 1. Landing Page (Shows the feature cards)
    public function index()
{
    // Calculate real-time stats
    $pendingCount = PurchaseOrder::whereIn('delivery_status', ['Scheduled', 'Delivered'])
        ->whereDoesntHave('inspectionReports')
        ->count();
    
    $successfulCount = InspectionReport::where('result', 'Passed')->count();
    
    $upcomingCount = PurchaseOrder::where('delivery_schedule', '>=', now())
        ->whereIn('delivery_status', ['Scheduled', 'Pending'])
        ->count();
    
    return view('access.inspectorate', compact('pendingCount', 'successfulCount', 'upcomingCount'));
}


    // 2. Pending List (The table that shows POs ready for inspection)
    public function view_pending()
    {
        $pendingInspections = PurchaseOrder::with(['supplier'])
            ->whereIn('delivery_status', ['Scheduled', 'Delivered'])
            ->whereDoesntHave('inspectionReports')
            ->orderBy('delivery_schedule', 'asc')
            ->paginate(10);

        return view('access.inspectorate-pending', compact('pendingInspections'));
    }

    // 3. Show the Inspection Form (MUST take PO parameter)
    public function createReport(PurchaseOrder $purchaseOrder)
    {
        // Inspection status options for the form
        $results = ['Passed', 'Failed', 'Conditional'];

        // FIX: Point to the correct, singular form path: access.inspect_form.form
        return view('access.inspectorate-form', compact('purchaseOrder', 'results'));
    }



    public function storeReport(Request $request, PurchaseOrder $purchaseOrder)
    {
        try {
            // 1. Validation
            $data = $request->validate([
                'report_number' => 'required|string|max:50|unique:inspection_reports,report_number',
                'inspection_date' => 'required|date',
                'result' => 'required|in:Passed,Failed,Conditional',
                'remarks' => 'nullable|string',
            ]);

            $data['purchase_order_id'] = $purchaseOrder->id;

            // 2. Database Transaction
            DB::beginTransaction();
            // ... (rest of storage logic) ...
            DB::commit();

            return redirect()->route('access.inspectorate.pending')->with(
                'success',
                "✅ Report submitted successfully for PO: {$purchaseOrder->po_number}."
            );
        } catch (ValidationException $e) {
            // CATCH ValidationException and redirect to the create route with the PO model
            return redirect()->route('access.inspectorate.create', $purchaseOrder)
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Inspection Report DB Error: ' . $e->getMessage());

            // CATCH Database error and redirect to the create route with the PO model
            return redirect()->route('access.inspectorate.create', $purchaseOrder)
                ->withInput()
                ->with('error', '❌ A database error occurred while submitting the report. Please check the Report Number for uniqueness.');
        }
    }

    // Show form to create new pending delivery
    public function createPending()
    {
        $suppliers = \App\Models\Supplier::orderBy('name')->get();
        return view('access.inspect_form.form', compact('suppliers'));
    }

    // Store new pending delivery
    public function storePending(Request $request)
    {
        try {
            $data = $request->validate([
                'po_number' => 'required|string|max:50|unique:purchase_orders,po_number',
                'supplier_id' => 'required|exists:suppliers,id',
                'purchase_order_id' => 'nullable|exists:purchase_orders,id',
                'order_date' => 'required|date',
                'delivery_schedule' => 'required|date',
                'total_amount' => 'required|numeric|min:0',
                'delivery_status' => 'required|in:Scheduled,Delivered',
                'notes' => 'nullable|string',
            ]);

            $data['payment_status_id'] = 1; // Set default payment status

            PurchaseOrder::create($data);

            return redirect()->route('access.inspectorate.pending')->with(
                'success',
                "✅ New pending delivery created: {$data['po_number']}"
            );
        } catch (ValidationException $e) {
            return redirect()->route('access.inspectorate.create_pending')
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    // 4. View Successful Reports
    public function view_successful()
    {
        $successfulReports = InspectionReport::with(['purchaseOrder.supplier'])
            ->where('result', 'Passed')
            ->orderBy('inspection_date', 'desc')
            ->paginate(10);

        return view('access.inspectorate-succesful', compact('successfulReports'));
    }
}
