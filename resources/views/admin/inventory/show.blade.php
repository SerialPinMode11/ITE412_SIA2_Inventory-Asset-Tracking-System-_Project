@extends('layouts.admin')

@section('title', 'View Asset: ' . $inventory->asset_tag)

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-minsu-green">Asset Details: <span class="text-minsu-gold">{{ $inventory->asset_tag }}</span></h2>
        <a href="{{ route('admin.inventory.index') }}" class="text-gray-600 hover:text-minsu-green transition duration-150 flex items-center space-x-2">
            <i class="fas fa-arrow-left"></i> <span>Back to Inventory</span>
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-xl p-8 border-t-4 border-minsu-green">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 text-lg">
            
            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Item Name</p>
                <p class="font-medium text-gray-900">{{ $inventory->item_name }}</p>
            </div>
            
            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Category</p>
                <p class="font-medium text-gray-900">{{ $inventory->category->name ?? 'N/A' }}</p>
            </div>

            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Condition</p>
                <p class="font-medium text-gray-900">{{ $inventory->condition }}</p>
            </div>
            
            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Status</p>
                <p class="font-medium text-gray-900">{{ $inventory->status }}</p>
            </div>
            
            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Location</p>
                <p class="font-medium text-gray-900">{{ $inventory->location->name ?? 'N/A' }}</p>
            </div>
            
            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Custodian</p>
                <p class="font-medium text-gray-900">{{ $inventory->custodian->name ?? 'Unassigned' }}</p>
            </div>
            
            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Acquired Date</p>
                <p class="font-medium text-gray-900">{{ $inventory->date_acquired->format('F d, Y') }}</p>
            </div>

            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Cost</p>
                <p class="font-medium text-gray-900">₱{{ number_format($inventory->acquisition_cost, 2) }}</p>
            </div>

            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Supplier</p>
                <p class="font-medium text-gray-900">{{ $inventory->supplier->name ?? 'N/A' }}</p>
            </div>

            <div class="border-b pb-2">
                <p class="text-sm font-semibold text-gray-500">Serial Number</p>
                <p class="font-medium text-gray-900">{{ $inventory->serial_number ?? 'N/A' }}</p>
            </div>
        </div>
        
        <div class="mt-6 pt-4 border-t">
            <p class="text-sm font-semibold text-gray-500 mb-1">Remarks</p>
            <p class="text-gray-700 whitespace-pre-wrap">{{ $inventory->remarks ?? 'No remarks provided.' }}</p>
        </div>
        
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin.inventory.edit', $inventory) }}" class="bg-minsu-gold text-minsu-green font-bold py-2 px-4 rounded-lg hover:bg-yellow-400 transition duration-150 shadow-md">
                <i class="fas fa-edit mr-1"></i> Edit Asset
            </a>
            <form action="{{ route('admin.inventory.destroy', $inventory) }}" method="POST" onsubmit="return confirm('Confirm deletion of this asset?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition duration-150 shadow-md">
                    <i class="fas fa-trash mr-1"></i> Delete Asset
                </button>
            </form>
        </div>
    </div>
</div>
@endsection