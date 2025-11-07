<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Access Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { 'minsu-green': '#145a32', 'minsu-gold': '#f1c40f', }, fontFamily: { 'poppins': ['Poppins', 'sans-serif'], }}}}
    </script>
    <style>body { font-family: 'Poppins', sans-serif; background-color: #f3f4ff; }</style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-2xl p-10 border-t-4 border-purple-500 text-center">
        <i class="fas fa-shipping-fast text-6xl text-purple-600 mb-4"></i>
        <h1 class="text-4xl font-bold text-minsu-green mb-2">Supplier Portal Access</h1>
        <p class="text-xl text-gray-700 mb-6">Delivery and Payment Tracking</p>

        <div class="border border-dashed border-purple-300 p-4 rounded-lg bg-purple-50 space-y-2">
            <p class="font-semibold text-purple-700">
                You have access to view and confirm delivery details as per procurement requests:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 text-left mx-auto max-w-md">
                <li><i class="fas fa-angle-right mr-2"></i>Check status of Purchase Orders (POs).</li>
                <li><i class="fas fa-angle-right mr-2"></i>View details of scheduled deliveries.</li>
                <li><i class="fas fa-angle-right mr-2"></i>Track payment status for delivered items.</li>
            </ul>
        </div>
        
        <a href="{{ url('/') }}" class="mt-8 inline-block px-6 py-3 bg-minsu-green text-white font-semibold rounded-full hover:bg-minsu-green/90 transition duration-300">
            ← Back to Homepage
        </a>
    </div>
</body>
</html>