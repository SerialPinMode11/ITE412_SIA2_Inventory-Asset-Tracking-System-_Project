
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Requisitioner Portal</title>
    
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
                        'requisitioner': '#2196F3', // Using a distinct blue for Requisitioner pages
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
            background-color: #f0f9ff; /* Very light blue/sky background */
        }
        .header { 
            background-color: #2196F3; /* Requisitioner Blue */
            color: white; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .nav-link {
            transition: background-color 0.2s;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Navbar/Header -->
    <div class="header sticky top-0 z-50 p-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <h1 class="text-xl md:text-2xl font-bold">REQUISITIONER PORTAL</h1>
            <span class="text-minsu-gold text-sm font-medium border border-minsu-gold px-2 py-0.5 rounded-full">
                {{ Auth::user()->role === 'user' ? 'REQUISITIONER' : ucfirst(Auth::user()->role) }}
            </span>
        </div>
        
        <div class="flex items-center space-x-4">
            {{-- Navigation Links --}}
            <a href="{{ route('user.dashboard') }}" class="nav-link px-3 py-2 text-white font-medium flex items-center space-x-2">
                <i class="fas fa-home"></i> <span>Dashboard</span>
            </a>
            
            {{-- Example New Link: Create Request --}}
            <a href="#" class="nav-link px-3 py-2 text-white font-medium flex items-center space-x-2">
                <i class="fas fa-plus-circle"></i> <span>New Request</span>
            </a>

            {{-- Example New Link: My Requests --}}
            <a href="#" class="nav-link px-3 py-2 text-white font-medium flex items-center space-x-2">
                <i class="fas fa-clipboard-list"></i> <span>My Requests</span>
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
        <div class="bg-white border-l-4 border-[#2196F3] p-4 mb-6 rounded-lg shadow-md">
            <p class="text-sm text-gray-700">
                You are logged in as a 
                <strong class="text-[#2196F3]">REQUISITIONER</strong>: 
                <span class="font-semibold">{{ Auth::user()->name }}</span> 
                ({{ Auth::user()->email }})
            </p>
        </div>
        
        <!-- Content Yield Area -->
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            @yield('content')
        </div>
    </div>
</body>
</html>