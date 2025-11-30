@extends('layouts.viewer')

@section('title', 'Tracker Asset Custodian Assigned')

@section('content')

<div class="p-6">
    <!-- Main Card Container -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
        
        <!-- Optional: Card Header Title -->
        <div class="px-6 py-4 border-b border-gray-100 bg-white">
            <h2 class="text-lg font-bold text-gray-800">Asset Custodian List</h2>
        </div>

        <!-- Scrollable Table Wrapper -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                
                <!-- Table Header -->
                <thead class="bg-orange-500 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Asset Tag</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Item Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Custodian Name</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Condition</th>
                        <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Warranty Expiry</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $asset)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            
                            <!-- Asset Tag -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                {{ $asset->asset_tag }}
                            </td>

                            <!-- Item Name -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $asset->item_name }}
                            </td>

                            <!-- Custodian Name -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                @if($asset->custodian)
                                    <span class="font-medium text-gray-800">{{ $asset->custodian->name }}</span>
                                @else
                                    <span class="text-gray-400 italic">Unassigned</span>
                                @endif
                            </td>

                            <!-- Condition (No Yellow Used) -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $condition = $asset->condition;
                                    $badgeClass = match($condition) {
                                        'New', 'Good' => 'bg-green-100 text-green-800',
                                        'Fair' => 'bg-blue-100 text-blue-800',
                                        'Needs Repair' => 'bg-orange-100 text-orange-800',
                                        'Disposed', 'Broken' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                    {{ $condition }}
                                </span>
                            </td>

                            <!-- Warranty Expiry -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $asset->warranty_expiry ? $asset->warranty_expiry->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="mt-2 text-sm">No assets found in the records.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection