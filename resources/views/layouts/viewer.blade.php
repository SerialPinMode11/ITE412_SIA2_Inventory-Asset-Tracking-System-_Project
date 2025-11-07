
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Supply Head Dashboard</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'minsu-green': '#145a32',
                        'minsu-gold': '#f1c40f',
                        'supply-head-main': '#FF9800', // Orange/Amber for Reporting/Oversight
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            background-color: #fffbeb; /* Very light gold/yellow background */
        }
        .header { 
            background-color: #FF9800; /* Supply Head Main Color */
            color: white; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            transition: background-color 0.2s;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Navbar/Header -->
    <div class="header sticky top-0 z-50 p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <h1 class="text-xl md:text-2xl font-bold">SUPPLY HEAD REPORTING SUITE</h1>
            <span class="text-minsu-green text-sm font-medium bg-white/90 px-2 py-0.5 rounded-full shadow-inner">
                OVERSIGHT
            </span>
        </div>
        
        <div class="flex items-center space-x-4">
            {{-- Navigation Links (Reporting/Review duties) --}}
            
            <a href="{{ route('viewer.report') }}" class="nav-link px-3 py-2 text-white font-medium flex items-center space-x-2">
                <i class="fas fa-chart-bar"></i> <span>Overall Report</span>
            </a>
            
            <a href="#" class="nav-link px-3 py-2 text-white font-medium flex items-center space-x-2">
                <i class="fas fa-search"></i> <span>Asset Tracking</span>
            </a>

            <a href="#" class="nav-link px-3 py-2 text-white font-medium flex items-center space-x-2">
                <i class="fas fa-handshake"></i> <span>Transfer Records</span>
            </a>

            {{-- Logout Form --}}
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link px-3 py-2 text-white font-medium flex items-center space-x-2 bg-red-600 hover:bg-red-700 rounded-md">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="container mx-auto px-4 py-6">
        <!-- Role/User Alert Banner -->
        <div class="bg-yellow-100 border-l-4 border-supply-head-main p-4 mb-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold text-supply-head-main flex items-center space-x-2">
                <i class="fas fa-eye"></i>
                <span>Viewing as Supply Head</span>
            </h3>
            <p class="text-sm text-gray-700 mt-1">
                Responsible for high-level oversight and reporting. Logged in as: 
                <strong class="text-minsu-green">{{ Auth::user()->name }}</strong> 
                (Role: <strong class="text-supply-head-main">{{ ucfirst(Auth::user()->role) }}</strong>).
            </p>
        </div>
        
        <!-- Content Yield Area -->
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            @yield('content')
        </div>
    </div>
</body>
</html>