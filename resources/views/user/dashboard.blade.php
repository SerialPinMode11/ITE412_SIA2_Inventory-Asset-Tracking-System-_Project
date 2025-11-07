

@extends('layouts.user')

@section('title', 'Requisitioner Dashboard')

@section('content')
<div class="py-4">
    <h2 class="text-3xl font-bold text-minsu-green mb-4">Welcome, {{ Auth::user()->name }}!</h2>
    <p class="text-gray-600 mb-6">Your role is to create and manage requisitions for assets and items.</p>

    <div class="p-6 mt-6 border border-[#2196F3] rounded-lg bg-blue-50 shadow-inner">
        <h4 class="text-xl font-semibold text-[#2196F3] mb-3">Key Requisitioner Actions</h4>
        <ul class="list-disc list-inside text-gray-700 space-y-2 ml-4">
            <li><i class="fas fa-file-invoice mr-2 text-[#2196F3]"></i>Create a new requisition request for a needed item.</li>
            <li><i class="fas fa-search-dollar mr-2 text-[#2196F3]"></i>View the status of pending and approved requests.</li>
            <li><i class="fas fa-box-open mr-2 text-[#2196F3]"></i>Confirm receipt and take responsibility for issued assets.</li>
            <li><i class="fas fa-exclamation-triangle mr-2 text-[#2196F3]"></i>Report issues or damage to assets currently under your responsibility.</li>
        </ul>
    </div>
</div>
@endsection