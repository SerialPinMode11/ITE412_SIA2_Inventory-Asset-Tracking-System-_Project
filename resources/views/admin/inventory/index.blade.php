@extends('layouts.admin')

@section('title', 'Asset Inventory Management')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-minsu-green">Physical Asset Inventory</h2>
        <a href="{{ route('admin.inventory.create') }}" class="bg-minsu-gold text-minsu-green font-semibold py-2 px-4 rounded-lg hover:bg-yellow-400 transition duration-150 shadow-md flex items-center space-x-2">
            <i class="fas fa-plus-circle"></i> <span>Add New Asset</span>
        </a>
    </div>

   @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-minsu-green/90 text-white">
                <tr>
                    {{-- ADDED MORE COLUMNS FOR COMPREHENSIVENESS --}}
                    <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider">Asset Tag</th>
                    <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider">Item Name</th>
                    <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider">Category</th>
                    <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider">Location</th>
                    <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider">Custodian</th>
                    <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider">Acquired</th>
                    <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider">Condition</th>
                    <th class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    <th class="px-3 py-3 text-center text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($assets as $asset)
                    <tr class="hover:bg-gray-50">
                        {{-- Asset Tag --}}
                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-minsu-green">{{ $asset->asset_tag }}</td>
                        {{-- Item Name --}}
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->item_name }}</td>
                        {{-- Category --}}
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asset->category->name ?? 'N/A' }}</td>
                        {{-- Location --}}
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asset->location->name ?? 'N/A' }}</td>
                        {{-- Custodian (New Column) --}}
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asset->custodian->name ?? 'Unassigned' }}</td>
                        {{-- Acquired --}}
                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asset->date_acquired->format('Y-m-d') }}</td>
                        {{-- Condition --}}
                        <td class="px-3 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($asset->condition == 'New') bg-green-100 text-green-800
                                @elseif($asset->condition == 'Good') bg-blue-100 text-blue-800
                                @elseif($asset->condition == 'Needs Repair') bg-yellow-100 text-yellow-800
                                @elseif($asset->condition == 'Disposed') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $asset->condition }}
                            </span>
                        </td>
                        {{-- Status --}}
                        <td class="px-3 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($asset->status == 'Issued') bg-minsu-gold/20 text-minsu-green
                                @elseif($asset->status == 'In Storage') bg-green-200 text-green-800
                                @elseif($asset->status == 'Under Maintenance') bg-yellow-300 text-yellow-900
                                @else bg-red-200 text-red-800
                                @endif">
                                {{ $asset->status }}
                            </span>
                        </td>
                        {{-- Actions --}}
                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-center">
                            <a href="{{ route('admin.inventory.show', $asset) }}" class="text-blue-600 hover:text-blue-900 mr-2" title="View"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.inventory.edit', $asset) }}" class="text-minsu-green hover:text-green-900 mr-2" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.inventory.destroy', $asset) }}" method="POST" class="inline" onsubmit="return confirm('WARNING! Deleting Asset Tag: {{ $asset->asset_tag }}. Are you absolutely sure? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No physical assets found in the inventory.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $assets->links() }}
    </div>
</div>
@endsection