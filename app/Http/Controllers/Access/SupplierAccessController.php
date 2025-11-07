<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierAccessController extends Controller
{
    /**
     * Show the main PO status page, optionally filtering by Supplier.
     */
    public function index(Request $request)
    {
        $supplierId = $request->query('supplier_id');
        $poNumber = $request->query('po_number');

        $query = PurchaseOrder::with(['supplier', 'paymentStatus']);
        
        // Filter by supplier if provided in the query string
        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }
        
        // Filter by PO number if provided
        if ($poNumber) {
            $query->where('po_number', 'LIKE', '%' . $poNumber . '%');
        }

        $purchaseOrders = $query->orderBy('delivery_schedule', 'asc')->paginate(10);
        $suppliers = Supplier::all(); // For the dropdown filter

        return view('access.supplier-po-status', compact('purchaseOrders', 'suppliers', 'supplierId', 'poNumber'));
    }

    /**
     * Show the details of a specific Purchase Order.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        // This is a public view, so we only show approved/relevant data.
        return view('access.supplier-po-show', compact('purchaseOrder'));
    }
}
