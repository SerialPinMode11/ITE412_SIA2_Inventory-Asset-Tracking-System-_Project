<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class SupplyHeadController extends Controller
{
    // Show overall report of successfully stocked/fulfilled assets
    public function overallReport()
    {
        $fulfilledPOs = PurchaseOrder::with(['supplier', 'inspectionReports'])
            ->where('final_disposition', 'Transferred_to_Head') // Only show POs successfully stocked by Admin
            ->orderBy('order_date', 'desc')
            ->paginate(10);
            
        return view('viewer.overallReport.index', compact('fulfilledPOs'));
    }
}