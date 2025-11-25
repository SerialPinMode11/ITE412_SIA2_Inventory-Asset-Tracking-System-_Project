<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Successful Inspection Reports</title>
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
                <i class="fas fa-check-double text-green-600"></i>
                <span>Successful Inspection Reports</span>
            </h1>
            <a href="{{ route('access.inspectorate.index') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-minsu-gold text-minsu-green font-semibold rounded-full hover:bg-yellow-400 transition duration-300">
                <i class="fas fa-arrow-left"></i> <span>Back to Dashboard</span>
            </a>
        </div>

        <div class="bg-white shadow-xl rounded-xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Report Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">PO Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Supplier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Inspection Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Result</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Remarks</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($successfulReports as $report)
                        <tr class="hover:bg-green-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-700">{{ $report->report_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->purchaseOrder->po_number ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->purchaseOrder->supplier->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->inspection_date ? \Carbon\Carbon::parse($report->inspection_date)->format('F d, Y') : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> {{ $report->result }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $report->remarks ?? 'No remarks' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">No successful inspection reports found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $successfulReports->links() }}
        </div>
    </div>
</body>
</html>
