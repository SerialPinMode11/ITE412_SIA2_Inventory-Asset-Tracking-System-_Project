<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AssetRequest;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisitionerController extends Controller
{
    // List the Requisitioner's own requests
    public function index()
    {
        $requests = AssetRequest::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(10);
            
        return view('user.request.index', compact('requests'));
    }

    // Show the New Request Form
    public function create()
    {
        $categories = AssetCategory::all();
        $priorities = ['Low', 'Medium', 'High', 'Urgent'];

        return view('user.form', compact('categories', 'priorities'));
    }

    // Store the New Request
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:asset_categories,id',
            'item_description' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:500',
            'priority' => 'required|in:Low,Medium,High,Urgent',
        ]);

        AssetRequest::create(array_merge($data, [
            'user_id' => Auth::id(),
            'status' => 'Pending',
        ]));

        return redirect()->route('user.requests.index')->with('success', '✅ Your asset request has been submitted for review.');
    }
    
}
