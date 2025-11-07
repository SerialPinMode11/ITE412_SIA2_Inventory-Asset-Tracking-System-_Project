<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MinSU Inspectorate Team Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { 'minsu-green': '#145a32', 'minsu-gold': '#f1c40f', }, fontFamily: { 'poppins': ['Poppins', 'sans-serif'], }}}}
    </script>
    <style>body { font-family: 'Poppins', sans-serif; background-color: #ecfeff; }</style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-2xl p-10 border-t-4 border-teal-500 text-center">
        <i class="fas fa-clipboard-check text-6xl text-teal-600 mb-4"></i>
        <h1 class="text-4xl font-bold text-minsu-green mb-2">Inspectorate Team Access</h1>
        <p class="text-xl text-gray-700 mb-6">Inspection and Quality Assurance Portal</p>

        <div class="border border-dashed border-teal-300 p-4 rounded-lg bg-teal-50 space-y-2">
            <p class="font-semibold text-teal-700">
                You are granted public access to the MinSU Asset Tracking System for your core function:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-1 text-left mx-auto max-w-md">
                <li><i class="fas fa-angle-right mr-2"></i>View Pending Deliveries for Inspection.</li>
                <li><i class="fas fa-angle-right mr-2"></i>Submit Digital Inspection Reports.</li>
                <li><i class="fas fa-angle-right mr-2"></i>Verify Item Specifications against POs.</li>
            </ul>
        </div>
        
        <a href="{{ url('/') }}" class="mt-8 inline-block px-6 py-3 bg-minsu-green text-white font-semibold rounded-full hover:bg-minsu-green/90 transition duration-300">
            ← Back to Homepage
        </a>
    </div>
</body>
</html>