@extends('layouts.admin')

@section('title', 'Pending Requisition Requests')

@section('content')
<div class="py-4">
    <h2 class="text-3xl font-bold text-minsu-green mb-6">Pending Asset Requisitions</h2>
    
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md">{{ session('success') }}</div>
    @endif
    
    <div class="bg-white shadow-lg rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-minsu-green text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Requester</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Item & Qty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Requested On</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($requests as $request)
                    <tr class="hover:bg-red-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-minsu-green">{{ $request->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $request->requester->name }}
                            <span class="text-xs text-gray-500 block">{{ $request->requester->email }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <strong>{{ $request->quantity }}x</strong> {{ $request->item_description }}
                            <span class="text-xs text-gray-500 block">Category: {{ $request->category->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($request->priority == 'Urgent') bg-red-500 text-white
                                @elseif($request->priority == 'High') bg-yellow-300 text-yellow-900
                                @else bg-gray-200 text-gray-800
                                @endif">
                                {{ $request->priority }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $request->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('admin.requests.show', $request) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Review">
                                <i class="fas fa-search"></i> Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No pending requisitions require review.</td>
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