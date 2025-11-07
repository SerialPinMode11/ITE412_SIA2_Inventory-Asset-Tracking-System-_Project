

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Portal - PO Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { 'minsu-green': '#145a32', 'minsu-gold': '#f1c40f', }, fontFamily: { 'poppins': ['Poppins', 'sans-serif'], }}}}
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4ff; }
        .tag-style { padding: 4px 8px; border-radius: 9999px; font-weight: 600; font-size: 0.75rem; }
    </style>
</head>
<body class="min-h-screen p-6">
    <div class="container mx-auto">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-minsu-green flex items-center space-x-3">
                <i class="fas fa-truck-loading text-purple-600"></i>
                <span>Supplier Portal: Purchase Order Status</span>
            </h1>
            <a href="{{ url('/') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-minsu-gold text-minsu-green font-semibold rounded-full hover:bg-yellow-400 transition duration-300">
                <i class="fas fa-home"></i> <span>Back to Home</span>
            </a>
        </div>
        
        <!-- Filter Form -->
        <form method="GET" class="bg-white p-4 rounded-lg shadow-md mb-6 flex space-x-4 items-end">
            <div class="flex-1">
                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Filter by Your Company</label>
                <select name="supplier_id" id="supplier_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">-- All Suppliers --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $supplierId == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
             <div class="flex-1">
                <label for="po_number" class="block text-sm font-medium text-gray-700">Filter by PO Number</label>
                <input type="text" name="po_number" id="po_number" value="{{ $poNumber }}" placeholder="Enter PO-XXXX-XXX" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-purple-500 focus:border-purple-500">
            </div>
            <button type="submit" class="bg-purple-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-purple-700 transition duration-300">
                Apply Filter
            </button>
        </form>

        <!-- PO Table -->
        <div class="bg-white shadow-xl rounded-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">PO Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Supplier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Delivery Schedule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Delivery Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Payment Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($purchaseOrders as $po)
                        <tr class="hover:bg-purple-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-700">{{ $po->po_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $po->supplier->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">₱{{ number_format($po->total_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $po->delivery_schedule ? $po->delivery_schedule->format('F d, Y') : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="tag-style bg-{{ match($po->delivery_status) { 'Delivered' => 'green-200', 'Scheduled' => 'blue-200', 'Cancelled' => 'red-200', default => 'gray-200' } }} text-{{ match($po->delivery_status) { 'Delivered' => 'green-800', 'Scheduled' => 'blue-800', 'Cancelled' => 'red-800', default => 'gray-800' } }}">
                                    {{ $po->delivery_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php $color = $po->paymentStatus->color_code; @endphp
                                <span class="tag-style" style="background-color: {{ $color }}30; color: {{ $color }}; border: 1px solid {{ $color }}">
                                    {{ $po->paymentStatus->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <a href="{{ route('supplier.po.show', $po) }}" class="text-purple-600 hover:text-purple-900 font-medium" title="View Details">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">No Purchase Orders found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $purchaseOrders->appends(request()->except('page'))->links() }}
        </div>
    </div>
</body>
</html>