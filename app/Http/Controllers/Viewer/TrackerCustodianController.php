<?php

namespace App\Http\Controllers\Viewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhysicalAsset; // Import the Model

class TrackerCustodianController extends Controller
{
     public function index() 
    {
        // Fetch assets including the related 'custodian' (employee) data
        // We use 'with' to prevent loading queries inside the loop (N+1 problem)
        $assets = PhysicalAsset::with('custodian')->get();

        // Pass the data to the view
        return view('viewer.tracker.index', compact('assets'));
    }
}
