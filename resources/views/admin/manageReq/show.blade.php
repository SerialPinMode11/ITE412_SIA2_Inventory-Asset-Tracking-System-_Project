@extends('layouts.admin')

@section('title', 'Review Requisition #' . $request->id)

@section('content')
<div class="py-4 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-minsu-green">Review Requisition #{{ $request->id }}</h2>
        <a href="{{ route('admin.requests.index') }}" class="text-gray-600 hover:text-minsu-green transition duration-150 flex items-center space-x-2">
            <i class="fas fa-arrow-left"></i> <span>Back to Pending List</span>
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-xl p-8 border-t-4 border-admin-alert">
        
        <h3 class="text-2xl font-semibold text-admin-alert mb-4 pb-2 border-b">Request Details</h3>
        
        <div class="grid grid-cols-2 gap-x-8 gap-y-4 mb-6">
            <p class="text-gray-700"><strong>Requester:</strong> {{ $request->requester->name }} ({{ $request->requester->email }})</p>
            <p class="text-gray-700"><strong>Request Date:</strong> {{ $request->created_at->format('M d, Y') }}</p>
            <p class="text-gray-700"><strong>Priority:</strong> <span class="font-bold text-red-600">{{ $request->priority }}</span></p>
            <p class="text-gray-700"><strong>Category:</strong> {{ $request->category->name ?? 'N/A' }}</p>
            <p class="text-gray-900 col-span-2 text-xl mt-2"><strong>Item:</strong> <span class="text-minsu-green font-bold">{{ $request->quantity }}x {{ $request->item_description }}</span></p>
        </div>

        <div class="mb-8 border-t pt-4">
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Justification / Reason</h4>
            <p class="text-gray-600 italic p-3 bg-gray-50 border rounded-lg">{{ $request->reason }}</p>
        </div>
        
        <h3 class="text-2xl font-semibold text-minsu-green mb-4 pb-2 border-b">Supply Officer Action</h3>

        <form action="{{ route('admin.requests.update', $request) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes (Mandatory for rejection, Optional for approval)</label>
                <textarea name="admin_notes" id="admin_notes" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">{{ old('admin_notes') }}</textarea>
                @error('admin_notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <button type="submit" name="action" value="reject" class="bg-red-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-red-700 transition duration-150 shadow-lg flex items-center space-x-2">
                    <i class="fas fa-times-circle"></i> <span>Reject Requisition</span>
                </button>
                <button type="submit" name="action" value="approve" class="bg-minsu-green text-white font-bold py-3 px-6 rounded-lg hover:bg-minsu-green/90 transition duration-150 shadow-lg flex items-center space-x-2">
                    <i class="fas fa-check-circle"></i> <span>Approve Requisition</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection