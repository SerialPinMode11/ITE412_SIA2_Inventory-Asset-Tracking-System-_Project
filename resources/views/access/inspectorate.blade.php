<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MinSU Inspectorate Team Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'minsu-green': '#145a32',
                        'minsu-gold': '#f1c40f',
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .stat-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .function-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .function-card:hover {
            border-left-color: #0d9488;
            transform: translateX(12px);
            background: linear-gradient(to right, #f0fdfa, #ffffff);
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-in {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="p-4 md:p-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Main Dashboard Card -->
        <div class="glass-card rounded-3xl shadow-2xl overflow-hidden animate-in">
            
            <!-- Hero Header -->
            <div class="relative bg-gradient-to-r from-teal-700 via-teal-600 to-cyan-600 p-10 text-white overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>
                <div class="relative text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white/20 rounded-2xl mb-6 backdrop-blur-lg shadow-lg">
                        <i class="fas fa-clipboard-check text-5xl"></i>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-3 tracking-tight">Inspectorate Portal</h1>
                    <p class="text-teal-50 text-xl font-medium">Quality Assurance & Compliance Management</p>
                </div>
            </div>

            <div class="p-8 md:p-12">
                
                <!-- Quick Stats Dashboard -->
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-chart-line text-teal-600 mr-3"></i>
                        Live Dashboard Metrics
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Pending Deliveries -->
                        <div class="stat-card bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border-2 border-amber-200 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-4 bg-amber-500 rounded-xl shadow-md">
                                    <i class="fas fa-clock text-white text-3xl"></i>
                                </div>
                                <span class="text-xs font-semibold text-amber-700 bg-amber-200 px-3 py-1 rounded-full">PENDING</span>
                            </div>
                            <div class="text-5xl font-extrabold text-amber-700 mb-2">{{ $pendingCount }}</div>
                            <div class="text-sm font-medium text-gray-700">Awaiting Inspection</div>
                        </div>

                        <!-- Successful Reports -->
                        <div class="stat-card bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 border-2 border-emerald-200 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-4 bg-emerald-500 rounded-xl shadow-md">
                                    <i class="fas fa-check-circle text-white text-3xl"></i>
                                </div>
                                <span class="text-xs font-semibold text-emerald-700 bg-emerald-200 px-3 py-1 rounded-full">PASSED</span>
                            </div>
                            <div class="text-5xl font-extrabold text-emerald-700 mb-2">{{ $successfulCount }}</div>
                            <div class="text-sm font-medium text-gray-700">Successful Reports</div>
                        </div>

                        <!-- Upcoming Deliveries -->
                        <div class="stat-card bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-6 border-2 border-blue-200 shadow-lg">
                            <div class="flex items-center justify-between mb-4">
                                <div class="p-4 bg-blue-500 rounded-xl shadow-md">
                                    <i class="fas fa-calendar-alt text-white text-3xl"></i>
                                </div>
                                <span class="text-xs font-semibold text-blue-700 bg-blue-200 px-3 py-1 rounded-full">UPCOMING</span>
                            </div>
                            <div class="text-5xl font-extrabold text-blue-700 mb-2">{{ $upcomingCount }}</div>
                            <div class="text-sm font-medium text-gray-700">Scheduled Deliveries</div>
                        </div>

                    </div>
                </div>

                <!-- Core Functions -->
                <div class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-tasks text-teal-600 mr-3"></i>
                        Core Functions
                    </h2>

                    <div class="space-y-4">
                        
                        <a href="{{ route('access.inspectorate.pending') }}" 
                           class="block function-card bg-white rounded-2xl p-6 shadow-md hover:shadow-xl group border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <div class="p-4 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl mr-5 group-hover:scale-110 transition-transform shadow-md">
                                        <i class="fas fa-truck text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-1 group-hover:text-teal-700">View Pending Deliveries</h3>
                                        <p class="text-sm text-gray-600">Review existing deliveries awaiting quality assessment</p>
                                    </div>
                                </div>
                                <i class="fas fa-arrow-right text-teal-600 text-2xl opacity-0 group-hover:opacity-100 transition-all"></i>
                            </div>
                        </a>

                        <a href="{{ route('access.inspectorate.create_pending') }}" 
                           class="block function-card bg-white rounded-2xl p-6 shadow-md hover:shadow-xl group border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl mr-5 group-hover:scale-110 transition-transform shadow-md">
                                        <i class="fas fa-plus-circle text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-1 group-hover:text-blue-700">Add New Pending Delivery</h3>
                                        <p class="text-sm text-gray-600">Register a new delivery for inspection tracking</p>
                                    </div>
                                </div>
                                <i class="fas fa-arrow-right text-blue-600 text-2xl opacity-0 group-hover:opacity-100 transition-all"></i>
                            </div>
                        </a>

                        <a href="{{ route('access.inspectorate.successful') }}" 
                           class="block function-card bg-white rounded-2xl p-6 shadow-md hover:shadow-xl group border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <div class="p-4 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl mr-5 group-hover:scale-110 transition-transform shadow-md">
                                        <i class="fas fa-check-double text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-1 group-hover:text-emerald-700">Verify Successful Reports</h3>
                                        <p class="text-sm text-gray-600">Cross-reference items against purchase order specifications</p>
                                    </div>
                                </div>
                                <i class="fas fa-arrow-right text-emerald-600 text-2xl opacity-0 group-hover:opacity-100 transition-all"></i>
                            </div>
                        </a>

                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-center pt-6 border-t border-gray-200">
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center space-x-3 px-10 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-bold rounded-2xl hover:from-teal-700 hover:to-cyan-700 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-lg">Return to Homepage</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-white/90 text-sm font-medium">
            <i class="fas fa-shield-alt mr-2"></i>MinSU Asset Tracking System © 2025 - Inspectorate Module
        </div>
    </div>
</body>
</html>
