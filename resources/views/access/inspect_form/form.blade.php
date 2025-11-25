<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Pending Delivery</title>
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
            <h1 class="text-3xl font-bold text-minsu-green">Add New Pending Delivery</h1>
            <a href="{{ route('access.inspectorate.index') }}" class="text-gray-600 hover:text-teal-600 transition duration-150 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i> <span>Back to Dashboard</span>
            </a>
        </div>

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                Please correct the errors in the form.
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-xl p-8 border-t-4 border-teal-600">
            <h2 class="text-2xl font-semibold text-teal-600 mb-6">Purchase Order Details</h2>

            <form action="{{ route('access.inspectorate.store_pending') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label for="po_number" class="block text-sm font-medium text-gray-700">PO Number <span class="text-red-500">*</span></label>
                        <input type="text" name="po_number" id="po_number" value="{{ old('po_number') }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                        @error('po_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier <span class="text-red-500">*</span></label>
                        <select name="supplier_id" id="supplier_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                            <option value="">-- Select Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date <span class="text-red-500">*</span></label>
                        <input type="date" name="order_date" id="order_date" value="{{ old('order_date', now()->format('Y-m-d')) }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                        @error('order_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="delivery_schedule" class="block text-sm font-medium text-gray-700">Delivery Schedule <span class="text-red-500">*</span></label>
                        <input type="date" name="delivery_schedule" id="delivery_schedule" value="{{ old('delivery_schedule') }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                        @error('delivery_schedule') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                        @error('total_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="delivery_status" class="block text-sm font-medium text-gray-700">Delivery Status <span class="text-red-500">*</span></label>
                        <select name="delivery_status" id="delivery_status" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
                            <option value="Scheduled" {{ old('delivery_status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="Delivered" {{ old('delivery_status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        </select>
                        @error('delivery_status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes / Item Details</label>
                        <textarea name="notes" id="notes" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="bg-minsu-green text-white font-bold py-3 px-6 rounded-lg hover:bg-minsu-green/90 transition duration-150 shadow-lg flex items-center space-x-2">
                        <i class="fas fa-plus"></i> <span>Create Pending Delivery</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
