<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhysicalAsset;
use App\Models\AssetCategory;
use App\Models\Supplier;
use App\Models\Location;
use App\Models\Employee;
use App\Models\InspectionReport;
use Illuminate\Http\Request;

// ADDED THESE NECESSARY USE STATEMENTS:
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log; // For Log::error
use Illuminate\Support\Facades\Auth; // For Auth::user()

class PhysicalAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = PhysicalAsset::with(['category', 'supplier', 'location', 'custodian'])
            ->latest()
            ->paginate(10);

        return view('admin.inventory.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This data is REQUIRED for the _form.blade.php select/dropdowns to work.
        $categories = AssetCategory::all();
        $suppliers = Supplier::all();
        $locations = Location::all();
        $custodians = Employee::all();
        $inspectionReports = InspectionReport::all();

        $conditions = ['New', 'Good', 'Fair', 'Needs Repair', 'Disposed'];
        $statuses = ['In Storage', 'Issued', 'Under Maintenance', 'Disposed', 'Lost'];

        // We DO NOT pass $asset here, it will be handled as null in the view
        return view('admin.inventory.create', compact('categories', 'suppliers', 'locations', 'custodians', 'inspectionReports', 'conditions', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation (Handles most user-input errors like unique constraints)
        $data = $request->validate([
            'asset_tag' => 'required|string|max:50|unique:physical_assets',
            'item_name' => 'required|string|max:150',
            'category_id' => 'required|exists:asset_categories,id',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'date_acquired' => 'required|date',
            'acquisition_cost' => 'nullable|numeric|min:0',
            'condition' => 'required|in:New,Good,Fair,Needs Repair,Disposed',
            'status' => 'required|in:In Storage,Issued,Under Maintenance,Disposed,Lost',
            'location_id' => 'nullable|exists:locations,id',
            'custodian_id' => 'nullable|exists:employees,id',
            'inspection_report_id' => 'nullable|exists:inspection_reports,id',
            'warranty_expiry' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        // 2. Database Operation with Error Handling (Try...Catch)
        try {
            DB::beginTransaction(); // Start a database transaction

            PhysicalAsset::create($data);
            
            DB::commit(); // Commit the transaction on success

            // SUCCESS RESPONSE
            return redirect()->route('admin.inventory.index')->with('success', '✅ Asset created successfully! Tag: ' . $data['asset_tag']);

        } catch (QueryException $e) {
            DB::rollBack(); // Rollback on error
            
            // Log the detailed error for the developer
            Log::error('Database Error during Asset Creation by Admin ' . (Auth::id() ?? 'N/A') . ': ' . $e->getMessage());

            // USER-FRIENDLY ERROR RESPONSE
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Database Error: Could not save the asset due to a system issue. Please contact support.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Catch any other unexpected exceptions
            Log::error('Unexpected Error during Asset Creation by Admin ' . (Auth::id() ?? 'N/A') . ': ' . $e->getMessage());

            // GENERIC ERROR RESPONSE
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PhysicalAsset $inventory)
    {
        return view('admin.inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhysicalAsset $inventory)
    {
        $categories = AssetCategory::all();
        $suppliers = Supplier::all();
        $locations = Location::all();
        $custodians = Employee::all();
        $inspectionReports = InspectionReport::all();

        $conditions = ['New', 'Good', 'Fair', 'Needs Repair', 'Disposed'];
        $statuses = ['In Storage', 'Issued', 'Under Maintenance', 'Disposed', 'Lost'];

        $asset = $inventory; // Renaming for clarity in the view

        return view('admin.inventory.edit', compact('asset', 'categories', 'suppliers', 'locations', 'custodians', 'inspectionReports', 'conditions', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhysicalAsset $inventory)
    {
        $data = $request->validate([
            'asset_tag' => 'required|string|max:50|unique:physical_assets,asset_tag,' . $inventory->id,
            'item_name' => 'required|string|max:150',
            'category_id' => 'required|exists:asset_categories,id',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'date_acquired' => 'required|date',
            'acquisition_cost' => 'nullable|numeric|min:0',
            'condition' => 'required|in:New,Good,Fair,Needs Repair,Disposed',
            'status' => 'required|in:In Storage,Issued,Under Maintenance,Disposed,Lost',
            'location_id' => 'nullable|exists:locations,id',
            'custodian_id' => 'nullable|exists:employees,id',
            'inspection_report_id' => 'nullable|exists:inspection_reports,id',
            'warranty_expiry' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        // 2. Database Operation with Error Handling (Try...Catch) for Update
        try {
            DB::beginTransaction();

            $inventory->update($data);

            DB::commit();
            
            return redirect()->route('admin.inventory.index')->with('success', '✅ Asset updated successfully! Tag: ' . $inventory->asset_tag);

        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Database Error during Asset Update by Admin ' . (Auth::id() ?? 'N/A') . ': ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Database Error: Could not update the asset. Please contact support.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Unexpected Error during Asset Update by Admin ' . (Auth::id() ?? 'N/A') . ': ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', '❌ An unexpected error occurred during update. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhysicalAsset $inventory)
    {
        // 2. Database Operation with Error Handling (Try...Catch) for Delete
        try {
            DB::beginTransaction();

            $tag = $inventory->asset_tag;
            $inventory->delete();

            DB::commit();

            return redirect()->route('admin.inventory.index')->with('success', '🗑️ Asset ' . $tag . ' deleted successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            
            // Check for potential foreign key constraint violation
            if (str_contains($e->getMessage(), 'foreign key')) {
                 return redirect()->back()
                    ->with('error', '❌ Deletion Failed: Asset is currently referenced by other records (e.g., transfers). You must delete related records first.');
            }
            
            Log::error('Database Error during Asset Deletion by Admin ' . (Auth::id() ?? 'N/A') . ': ' . $e->getMessage());

            return redirect()->back()
                ->with('error', '❌ Database Error: Could not delete the asset. Please contact support.');
        }
    }
}