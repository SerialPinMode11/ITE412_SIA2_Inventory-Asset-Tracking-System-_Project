<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisitionManagementController extends Controller
{
    // List all Pending Requests for Admin review
    public function index()
    {
        $requests = AssetRequest::with(['requester', 'category'])
            ->where('status', 'Pending')
            ->orderBy('priority', 'desc')
            ->paginate(10);
            
        return view('admin.manageReq.index', compact('requests'));
    }

    // Show the Request Review Form
    public function show(AssetRequest $request)
    {
        return view('admin.manageReq.show', compact('request'));
    }

    // Handle Approval or Rejection
    public function update(Request $request, AssetRequest $assetRequest)
    {
        // 1. Validation
        $action = $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string',
        ]);

        // 2. Determine New Status
        $newStatus = ($action['action'] === 'approve') ? 'Approved' : 'Rejected';
        $messageVerb = ($action['action'] === 'approve') ? 'Approved' : 'Rejected';
        
        // 3. Update the Request
        $assetRequest->update([
            'status' => $newStatus,
            'approved_by_user_id' => Auth::id(), // Record the Admin user
            'admin_notes' => $action['admin_notes'],
        ]);

        return redirect()->route('admin.requests.index')->with('success', 
            "✅ Requisition #{$assetRequest->id} has been {$messageVerb}."
        );
    }
}
