

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PO Details: {{ $purchaseOrder->po_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { 'minsu-green': '#145a32', 'minsu-gold': '#f1c40f', }, fontFamily: { 'poppins': ['Poppins', 'sans-serif'], }}}}
    </script>
    <style>body { font-family: 'Poppins', sans-serif; background-color: #f3f4ff; }</style>
</head>
<body class="min-h-screen p-6">
    <div class="container mx-auto max-w-4xl">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-minsu-green">
                Purchase Order: <span class="text-purple-600">{{ $purchaseOrder->po_number }}</span>
            </h1>
            <a href="{{ route('supplier.po.index') }}" class="text-gray-600 hover:text-purple-600 transition duration-150 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i> <span>Back to PO List</span>
            </a>
        </div>

        <div class="bg-white shadow-xl rounded-xl p-8 border-t-4 border-purple-600">
            <h2 class="text-2xl font-semibold text-purple-600 mb-6">Order Summary</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 text-base">
                
                <div class="border-b pb-2">
                    <p class="text-sm font-semibold text-gray-500">Supplier Name</p>
                    <p class="font-medium text-gray-900">{{ $purchaseOrder->supplier->name }}</p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm font-semibold text-gray-500">Order Date</p>
                    <p class="font-medium text-gray-900">{{ $purchaseOrder->order_date->format('F d, Y') }}</p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm font-semibold text-gray-500">Total Amount</p>
                    <p class="font-bold text-2xl text-minsu-green">₱{{ number_format($purchaseOrder->total_amount, 2) }}</p>
                </div>
                
                <div class="border-b pb-2">
                    <p class="text-sm font-semibold text-gray-500">Scheduled Delivery</p>
                    <p class="font-medium text-red-600">{{ $purchaseOrder->delivery_schedule ? $purchaseOrder->delivery_schedule->format('F d, Y') : 'TBD' }}</p>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Delivery Status</p>
                    <span class="tag-style text-lg" style="background-color: {{ match($purchaseOrder->delivery_status) { 'Delivered' => '#dcfce7', 'Scheduled' => '#dbeafe', 'Cancelled' => '#fee2e2', default => '#f3f4f6' } }}; color: {{ match($purchaseOrder->delivery_status) { 'Delivered' => '#16a34a', 'Scheduled' => '#2563eb', 'Cancelled' => '#dc2626', default => '#6b7280' } }}; padding: 6px 12px; border-radius: 8px;">
                        {{ $purchaseOrder->delivery_status }}
                    </span>
                </div>
                
                <div>
                    <p class="text-sm font-semibold text-gray-500 mb-1">Payment Status</p>
                    @php $color = $purchaseOrder->paymentStatus->color_code; @endphp
                    <span class="tag-style text-lg" style="background-color: {{ $color }}30; color: {{ $color }}; border: 1px solid {{ $color }}; padding: 6px 12px; border-radius: 8px;">
                        {{ $purchaseOrder->paymentStatus->name }}
                    </span>
                </div>
            </div>
            
            <div class="mt-8 pt-4 border-t border-gray-200">
                 <p class="text-sm font-semibold text-gray-500 mb-1">Notes / Items Covered</p>
                 <p class="text-gray-700 whitespace-pre-wrap">{{ $purchaseOrder->notes ?? 'No specific notes recorded.' }}</p>
            </div>
        </div>
    </div>
</body>
</html>