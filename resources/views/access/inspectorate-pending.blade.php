

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspectorate Portal - Pending Deliveries</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { 'minsu-green': '#145a32', 'minsu-gold': '#f1c40f', }, fontFamily: { 'poppins': ['Poppins', 'sans-serif'], }}}}
    </script>
    <style>body { font-family: 'Poppins', sans-serif; background-color: #ecfeff; }</style>
</head>
<body class="min-h-screen p-6">
    <div class="container mx-auto">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-minsu-green flex items-center space-x-3">
                <i class="fas fa-clipboard-check text-teal-600"></i>
                <span>MinSU Inspectorate: Pending Deliveries</span>
            </h1>
            <a href="{{ url('/') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-minsu-gold text-minsu-green font-semibold rounded-full hover:bg-yellow-400 transition duration-300">
                <i class="fas fa-home"></i> <span>Back to Home</span>
            </a>
        </div>
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-xl rounded-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-teal-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">PO Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Supplier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Delivery Schedule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($pendingInspections as $po)
                        <tr class="hover:bg-teal-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-teal-700">{{ $po->po_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $po->supplier->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $po->delivery_schedule ? $po->delivery_schedule->format('F d, Y') : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $po->delivery_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <a href="{{ route('access.inspectorate.create', $po) }}" class="text-minsu-green hover:text-green-700 font-semibold transition duration-150">
                                    <i class="fas fa-file-signature mr-1"></i> Submit Report
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">No deliveries are currently pending for inspection.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $pendingInspections->links() }}
        </div>
    </div>
</body>
</html>