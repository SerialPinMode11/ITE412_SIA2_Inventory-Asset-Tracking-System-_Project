@extends('layouts.admin')

@section('title', 'Procurement & Final Acceptance')

@section('content')
<div class="py-4">
    <h2 class="text-3xl font-bold text-minsu-green mb-6">Procurement Final Acceptance Queue</h2>
    <p class="text-gray-600 mb-4">These **Inspection Reports** require your final acceptance to be stocked or rejected.</p>
    
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md">{{ session('error') }}</div>
    @endif
    
    <div class="bg-white shadow-lg rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-minsu-green text-white">
                <tr>
                    {{-- MATCHES Inspectorate Successful Reports Headers --}}
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Report Number with PO Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Inspection Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Result</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Inspector Remarks</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Final Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($inspectionReports as $report)
                    @php 
                        $reportResult = $report->result ?? 'N/A';
                        $po = $report->purchaseOrder;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        {{-- Report Number with PO --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-minsu-green">
                            {{ $report->report_number }}
                            <span class="text-xs text-gray-500 block">PO: {{ $po->po_number ?? 'N/A' }}</span>
                        </td>
                        {{-- Supplier --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $po->supplier->name ?? 'N/A' }}</td>
                        {{-- Inspection Date --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($report->inspection_date)->format('M d, Y') ?? 'N/A' }}</td>
                        {{-- Result --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($reportResult == 'Passed') bg-green-100 text-green-800
                                @elseif($reportResult == 'Conditional') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $reportResult }}
                            </span>
                        </td>
                        {{-- Inspector Remarks --}}
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $report->remarks ?? 'No remarks' }}</td>
                        
                        {{-- Final Action --}}
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            @if ($reportResult == 'Passed' || $reportResult == 'Conditional')
                                {{-- BUTTON 1: ACCEPT and SEND TO SUPPLY HEAD (Stocked) --}}
                                <form action="{{ route('admin.procurement.acceptStock', $report) }}" method="POST" class="inline" onsubmit="return confirm('Confirm Stocking PO {{ $po->po_number }}? This creates a new Asset record AND notifies the Supply Head.');">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="bg-minsu-gold text-minsu-green font-semibold py-1 px-3 rounded-lg hover:bg-yellow-400 transition duration-150 shadow-md">
                                        <i class="fas fa-arrow-up mr-1"></i> Stock & Send to Head
                                    </button>
                                </form>
                            @else
                                {{-- BUTTON 2: DISPOSE/CANCEL (for Failed/Rejected Reports) --}}
                                <form action="{{ route('admin.procurement.disposeCancel', $report) }}" method="POST" class="inline" onsubmit="return confirm('WARNING! Confirm Disposition/Cancellation of PO {{ $po->po_number }}? This removes it from the queue.');">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="bg-red-600 text-white font-semibold py-1 px-3 rounded-lg hover:bg-red-700 transition duration-150 shadow-md">
                                        <i class="fas fa-trash-alt mr-1"></i> Dispose/Cancel
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No Inspection Reports are ready for final procurement action.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $inspectionReports->links() }}
    </div>
</div>
@endsection