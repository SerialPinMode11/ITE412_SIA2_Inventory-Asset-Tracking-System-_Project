

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Inspection Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { 'minsu-green': '#145a32', 'minsu-gold': '#f1c40f', }, fontFamily: { 'poppins': ['Poppins', 'sans-serif'], }}}}
    </script>
    <style>body { font-family: 'Poppins', sans-serif; background-color: #ecfeff; }</style>
</head>
<body class="min-h-screen p-6">
    <div class="container mx-auto max-w-4xl">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-minsu-green">
                Inspection Report for PO: <span class="text-teal-600">{{ $purchaseOrder->po_number }}</span>
            </h1>
            <a href="{{ route('access.inspectorate.index') }}" class="text-gray-600 hover:text-teal-600 transition duration-150 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i> <span>Back to Pending List</span>
            </a>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow-xl rounded-xl p-8 border-t-4 border-teal-600">
            <h2 class="text-2xl font-semibold text-teal-600 mb-6">Delivery Details Verification</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 mb-8 pb-4 border-b">
                <p class="text-gray-700"><strong>Supplier:</strong> {{ $purchaseOrder->supplier->name }}</p>
                <p class="text-gray-700"><strong>Scheduled Delivery:</strong> {{ $purchaseOrder->delivery_schedule ? $purchaseOrder->delivery_schedule->format('F d, Y') : 'N/A' }}</p>
                <p class="text-gray-700 md:col-span-2"><strong>Items:</strong> {{ $purchaseOrder->notes ?? 'Review item specification against attached documents.' }}</p>
            </div>

            <form action="{{ route('access.inspectorate.store', $purchaseOrder) }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="report_number" class="block text-sm font-medium text-gray-700">Report Number <span class="text-red-500">*</span></label>
                        <input type="text" name="report_number" id="report_number" value="{{ old('report_number') }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                        @error('report_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="inspection_date" class="block text-sm font-medium text-gray-700">Inspection Date <span class="text-red-500">*</span></label>
                        <input type="date" name="inspection_date" id="inspection_date" value="{{ old('inspection_date', now()->format('Y-m-d')) }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                        @error('inspection_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    
                    <div>
                        <label for="purchase_order_id" class="block text-sm font-medium text-gray-700">Order ID <span class="text-red-500">*</span></label>
                        <input type="text" name="purchase_order_id" id="purchase_order_id" value="{{ old('purchase_order_id') }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                        @error('purchase_order_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="result" class="block text-sm font-medium text-gray-700">Inspection Result <span class="text-red-500">*</span></label>
                        <select name="result" id="result" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                            <option value="">-- Select Result --</option>
                            @foreach ($results as $r)
                                <option value="{{ $r }}" {{ old('result') == $r ? 'selected' : '' }}>{{ $r }}</option>
                            @endforeach
                        </select>
                        @error('result') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks / Discrepancies</label>
                        <textarea name="remarks" id="remarks" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">{{ old('remarks') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="bg-minsu-green text-white font-bold py-3 px-6 rounded-lg hover:bg-minsu-green/90 transition duration-150 shadow-lg flex items-center space-x-2">
                        <i class="fas fa-save"></i> <span>Submit Final Report</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>