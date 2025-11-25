@extends('layouts.user')

@section('title', 'My Asset Requests')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-minsu-green">My Asset Requisitions</h2>
        <a href="{{ route('user.requests.create') }}" class="bg-minsu-gold text-minsu-green font-semibold py-2 px-4 rounded-lg hover:bg-yellow-400 transition duration-150 shadow-md flex items-center space-x-2">
            <i class="fas fa-plus-circle"></i> <span>New Request</span>
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md">{{ session('success') }}</div>
    @endif
    
    <div class="bg-white shadow-lg rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-requisitioner text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item / Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Admin Notes</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($requests as $request)
                    <tr class="hover:bg-blue-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-requisitioner">{{ $request->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $request->item_description }}
                            <span class="text-xs text-gray-500 block">({{ $request->category->name ?? 'Uncategorized' }})</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $request->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($request->priority == 'Urgent') bg-red-100 text-red-800
                                @elseif($request->priority == 'High') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $request->priority }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($request->status == 'Approved') bg-green-100 text-green-800
                                @elseif($request->status == 'Rejected') bg-red-100 text-red-800
                                @elseif($request->status == 'Fulfilled') bg-blue-100 text-blue-800
                                @else bg-yellow-200 text-yellow-800
                                @endif">
                                {{ $request->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $request->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $request->admin_notes ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">You have no active asset requests.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>
@endsection