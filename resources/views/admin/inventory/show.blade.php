@extends('layouts.admin')

@section('title', 'View Asset: ' . $inventory->asset_tag)

@section('content')
    <div class="py-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-minsu-green">Asset Details: <span
                    class="text-minsu-gold">{{ $inventory->asset_tag }}</span></h2>
            <a href="{{ route('admin.inventory.index') }}"
                class="text-gray-600 hover:text-minsu-green transition duration-150 flex items-center space-x-2">
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
            {{-- QR Code Button --}}
            <div class="mt-8 flex justify-end space-x-3">
                <!-- NEW: Print QR Code Button -->
                <button
                    onclick="printQrCode('{{ route('admin.inventory.qr-code', $inventory) }}', '{{ $inventory->asset_tag }}')"
                    class="bg-minsu-green text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition duration-150 shadow-md">
                    <i class="fas fa-qrcode mr-1"></i> Print QR Code
                </button>
                {{-- <a href="{{ route('admin.inventory.qr-code-G', $inventory) }}"
                    class="bg-minsu-gold text-minsu-green font-bold py-2 px-4 rounded-lg hover:bg-yellow-400 transition duration-150 shadow-md">
                    <i class="fas fa-edit mr-1"></i> TEST Button
                </a> --}}
            </div>
            {{-- Edit Button --}}
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.inventory.edit', $inventory) }}"
                    class="bg-minsu-gold text-minsu-green font-bold py-2 px-4 rounded-lg hover:bg-yellow-400 transition duration-150 shadow-md">
                    <i class="fas fa-edit mr-1"></i> Edit Asset
                </a>
                <form action="{{ route('admin.inventory.destroy', $inventory) }}" method="POST"
                    onsubmit="return confirm('Confirm deletion of this asset?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition duration-150 shadow-md">
                        <i class="fas fa-trash mr-1"></i> Delete Asset
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

<!-- Add this script at the end of your blade file or in a shared scripts section -->
<script>
function printQrCode(qrCodeUrl, assetTag) {
    const printWindow = window.open('', '', 'width=600,height=700');
    
    printWindow.document.write(`
        <html>
            <head>
                <title>QR Code - ${assetTag}</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        padding: 20px;
                        background-color: #f5f5f5;
                    }
                    .qr-container {
                        background-color: white;
                        padding: 30px;
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                        text-align: center;
                    }
                    h2 {
                        color: #1a7a4a;
                        margin-bottom: 20px;
                    }
                    img {
                        max-width: 100%;
                        margin: 20px 0;
                    }
                    .asset-info {
                        margin-top: 20px;
                        text-align: left;
                        font-size: 12px;
                        color: #666;
                    }
                    @media print {
                        body {
                            background-color: white;
                        }
                        .no-print {
                            display: none;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="qr-container">
                    <h2>Asset QR Code</h2>
                    <p><strong>${assetTag}</strong></p>
                    <img src="${qrCodeUrl}" alt="QR Code for ${assetTag}" />
                    <p style="margin-top: 15px; font-size: 11px; color: #999;">
                        Generated on: ${new Date().toLocaleString()}
                    </p>
                </div>
                <button class="no-print" onclick="window.print()" style="margin-top: 20px; padding: 10px 20px; background-color: #1a7a4a; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Print QR Code
                </button>
            </body>
        </html>
    `);
    
    printWindow.document.close();
}
</script>