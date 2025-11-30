@extends('layouts.viewer')

@section('title', 'Overall Asset Acquisition Report')

@section('content')
<div class="py-4">
    <h2 class="text-3xl font-bold text-minsu-green mb-6">Final Asset Acquisition Report (For Supply Head)</h2>
    <p class="text-gray-600 mb-8">This report shows all Purchase Orders that have been successfully acquired, inspected, and stocked (Final Disposition: Transferred to Head).</p>
    
    {{-- Added summary stats cards for total cost and number of successful reports --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Overall Acquisition Cost Card --}}
        <div class="bg-gradient-to-br from-supply-head-main to-green-700 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-green-100 mb-1">Total Acquisition Cost</p>
                    <p class="text-4xl font-bold">₱{{ number_format($fulfilledPOs->sum('total_amount'), 2) }}</p>
                </div>
                <div class="text-6xl opacity-20">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
            <p class="text-sm text-green-100 mt-3">Across all fulfilled purchase orders</p>
        </div>

        {{-- Successful Reports Card --}}
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-100 mb-1">Successful Reports</p>
                    <p class="text-4xl font-bold">{{ $fulfilledPOs->count() }}</p>
                </div>
                <div class="text-6xl opacity-20">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <p class="text-sm text-blue-100 mt-3">Purchase Orders completed</p>
        </div>
    </div>
    
    <div class="bg-white shadow-lg rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-supply-head-main text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">PO Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Acquisition Cost</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Order Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Inspection Result</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Final Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($fulfilledPOs as $po)
                    @php 
                        $report = $po->inspectionReports->first(); 
                        $reportResult = $report->result ?? 'N/A';
                    @endphp
                    <tr class="hover:bg-yellow-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-minsu-green">{{ $po->po_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $po->supplier->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600">₱{{ number_format($po->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $po->order_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($reportResult == 'Passed') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $reportResult }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Stocked/Fulfilled
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No fulfilled POs are ready for final reporting.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $fulfilledPOs->links() }}
    </div>
</div>
@endsection
