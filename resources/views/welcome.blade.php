

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MinSU Supply Office | Asset Tracking System</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome for Icons (Ensure it's included) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'minsu-green': '#145a32',
                        'minsu-gold': '#f1c40f',
                        'supply-head-main': '#FF9800', // Added for modal consistency
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
        }

        .gradient-bg {
            /* Adjusted for better visibility of elements */
            background: linear-gradient(135deg, #145a32 0%, #1a7a42 70%, #f1c40f 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Style for the alert/success message */
        .alert-container {
            position: fixed;
            top: 6rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            width: 90%;
            max-width: 600px;
        }

        .alert-success {
            padding: 1rem;
            border-radius: 0.5rem;
            color: #15803d;
            background: #dcfce7;
            border: 1px solid #86efac;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Success Message Alert -->
    @if (session('success'))
        <div class="alert-container animate-fade-in">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif

    <!-- Navbar -->
    <nav class="bg-minsu-green shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-minsu-gold rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-minsu-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-white text-xl font-semibold">MinSU Supply Office</span>
                </a>

                {{-- LOGIC: Show appropriate buttons based on login status --}}
                @if (Auth::check())
                    <div class="flex items-center space-x-4">
                        {{-- Logged in user info/links --}}
                        <span class="text-white text-sm hidden sm:block">
                            Logged in as: <strong class="text-minsu-gold">{{ Auth::user()->name }}</strong>
                        </span>

                        {{-- Role-based Dashboard Link --}}
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="px-4 py-2 bg-yellow-400 text-minsu-green font-semibold rounded-full hover:bg-yellow-500 transition duration-300 shadow-md">
                                Supply Officer
                            </a>
                        @elseif (Auth::user()->role === 'viewer')
                            <a href="{{ route('viewer.report') }}"
                                class="px-4 py-2 bg-yellow-400 text-minsu-green font-semibold rounded-full hover:bg-yellow-500 transition duration-300 shadow-md">
                                Supply Head
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}"
                                class="px-4 py-2 bg-yellow-400 text-minsu-green font-semibold rounded-full hover:bg-yellow-500 transition duration-300 shadow-md">
                                Requisitioner
                            </a>
                        @endif

                        {{-- Logout Button --}}
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white font-semibold rounded-full hover:bg-red-700 transition duration-300 shadow-md">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Not Logged in buttons --}}
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login.form') }}"
                            class="px-6 py-2 bg-minsu-gold text-minsu-green font-semibold rounded-full hover:bg-yellow-400 transition duration-300 shadow-md hover:shadow-lg">
                            Log In
                        </a>
                        <a href="{{ route('register.form') }}"
                            class="hidden sm:block px-6 py-2 border border-minsu-gold text-minsu-gold font-semibold rounded-full hover:bg-minsu-gold hover:text-minsu-green transition duration-300 shadow-md hover:shadow-lg">
                            Register
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white py-20 md:py-32 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-minsu-gold rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center animate-fade-in">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Welcome to MinSU Supply Office
                    <span class="block text-minsu-gold mt-2">Asset Tracking System</span>
                </h1>
                <p class="text-lg md:text-xl mb-8 text-gray-100 leading-relaxed max-w-3xl mx-auto">
                    Efficiently track, manage, and monitor organizational assets — from acquisition to disposal — with
                    QR-powered transparency and accountability.
                </p>

                {{-- LOGIN/ACCESS BUTTON (Conditionally rendered) --}}
                @if (!Auth::check())
                    {{-- Added class 'hero-access-btn' for JS to hook onto --}}
                    <a href="#"
                        class="hero-access-btn inline-block px-8 py-4 bg-minsu-gold text-minsu-green font-bold rounded-full hover:bg-yellow-400 transition duration-300 shadow-2xl hover:shadow-minsu-gold/50 hover:scale-105 transform">
                        Get Started Now →
                    </a>
                @else
                    {{-- Display a subtle message for logged-in users on the main hero --}}
                    <div class="inline-block px-8 py-4 bg-white/20 text-white font-semibold rounded-full">
                        Welcome back, {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }}). Navigate using the
                        links above.
                    </div>
                @endif
            </div>
        </div>

        <!-- Decorative wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                    fill="#f8f9fa" />
            </svg>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-minsu-green mb-4">About MinSU</h2>
                <div class="w-24 h-1 bg-minsu-gold mx-auto mb-6"></div>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Mindoro State University (MinSU) is a premier educational institution committed to excellence in
                    education, research, and community service. The Supply Office ensures transparency, efficiency, and
                    accountability in managing university assets.
                </p>
            </div>

            <!-- System Highlights -->
            <div class="max-w-5xl mx-auto">
                <h3 class="text-2xl md:text-3xl font-bold text-minsu-green text-center mb-12">System Highlights</h3>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 card-hover border-t-4 border-minsu-green">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-minsu-green to-green-600 rounded-xl flex items-center justify-center mb-6 animate-float">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                </path>
                            </svg>
                        </div>
                        <h5 class="text-xl font-bold text-minsu-green mb-3">QR Asset Tracking</h5>
                        <p class="text-gray-600 leading-relaxed">Easily scan assets for real-time information and status
                            updates.</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 card-hover border-t-4 border-minsu-gold">
                        <div class="w-16 h-16 bg-gradient-to-br from-minsu-gold to-yellow-500 rounded-xl flex items-center justify-center mb-6 animate-float"
                            style="animation-delay: 0.2s;">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </div>
                        <h5 class="text-xl font-bold text-minsu-green mb-3">Lifecycle Management</h5>
                        <p class="text-gray-600 leading-relaxed">Track assets from acquisition to disposal and bidding.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 card-hover border-t-4 border-minsu-green">
                        <div class="w-16 h-16 bg-gradient-to-br from-minsu-green to-green-600 rounded-xl flex items-center justify-center mb-6 animate-float"
                            style="animation-delay: 0.4s;">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h5 class="text-xl font-bold text-minsu-green mb-3">User Reports</h5>
                        <p class="text-gray-600 leading-relaxed">Users can report defective or missing assets with one
                            click.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-minsu-green text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <div class="w-10 h-10 bg-minsu-gold rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-minsu-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span class="font-semibold">MinSU Supply Office</span>
                </div>
                <p class="text-gray-200 text-sm">
                    &copy; {{ date('Y') }} Mindoro State University Supply Office. All rights reserved.
                </p>
            </div>
        </div>
    </footer>


    {{-- ========================================================== --}}
    {{-- ACCESS GATE MODAL --}}
    {{-- ========================================================== --}}
    @guest
        {{-- Added 'hidden' for initial state, will be removed by JS on DOMContentLoaded --}}
        <div id="accessModal"
            class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-[100] transition-opacity duration-300 hidden opacity-0">
            <div
                class="bg-white rounded-xl shadow-2xl w-full max-w-2xl p-8 transform scale-95 transition-transform duration-300">

                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-minsu-green mb-2">Select Your Access Role</h2>
                    <p class="text-gray-600">Please choose the access level that corresponds to your function within the
                        system.</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                    {{-- Option 1: Requisitioner (Login) --}}
                    <a href="{{ route('login.form') }}"
                        class="p-4 rounded-lg text-center bg-blue-100 hover:bg-blue-200 border-b-4 border-blue-500 transition duration-150 shadow-md flex flex-col items-center justify-center space-y-2">
                        <i class="fas fa-file-invoice text-3xl text-blue-600"></i>
                        <span class="font-semibold text-blue-700">Requisitioner</span>
                        <span class="text-xs text-gray-500">(Login Required)</span>
                    </a>

                    {{-- Option 2: Supply Officer (Login) --}}
                    <a href="{{ route('login.form') }}"
                        class="p-4 rounded-lg text-center bg-minsu-green/10 hover:bg-minsu-green/20 border-b-4 border-minsu-green transition duration-150 shadow-md flex flex-col items-center justify-center space-y-2">
                        <i class="fas fa-boxes text-3xl text-minsu-green"></i>
                        <span class="font-semibold text-minsu-green">Supply Officer</span>
                        <span class="text-xs text-gray-500">(Login Required)</span>
                    </a>

                    {{-- Option 3: Supply Head (Login) --}}
                    <a href="{{ route('login.form') }}"
                        class="p-4 rounded-lg text-center bg-yellow-100 hover:bg-yellow-200 border-b-4 border-supply-head-main transition duration-150 shadow-md flex flex-col items-center justify-center space-y-2">
                        <i class="fas fa-chart-line text-3xl text-supply-head-main"></i>
                        <span class="font-semibold text-supply-head-main">Supply Head</span>
                        <span class="text-xs text-gray-500">(Login Required)</span>
                    </a>

                    <div class="col-span-full h-px bg-gray-200 my-2"></div>

                    {{-- Option 4: MinSu Inspectorate Team (Public Access) --}}
                    <a href="{{ route('access.inspectorate.index') }}"
                        class="p-4 rounded-lg text-center bg-teal-100 hover:bg-teal-200 border-b-4 border-teal-500 transition duration-150 shadow-md flex flex-col items-center justify-center space-y-2">
                        <i class="fas fa-search-dollar text-3xl text-teal-600"></i>
                        <span class="font-semibold text-teal-700">Inspectorate Team</span>
                        <span class="text-xs text-gray-500">(Public View)</span>
                    </a>

                    {{-- Option 5: Supplier (Public Access) --}}
                    <a href="{{ route('access.supplier') }}"
                        class="p-4 rounded-lg text-center bg-purple-100 hover:bg-purple-200 border-b-4 border-purple-500 transition duration-150 shadow-md flex flex-col items-center justify-center space-y-2">
                        <i class="fas fa-truck-loading text-3xl text-purple-600"></i>
                        <span class="font-semibold text-purple-700">Supplier</span>
                        <span class="text-xs text-gray-500">(Public View)</span>
                    </a>

                    {{-- Option 6: Finance Unit (Disabled) --}}
                    <div
                        class="p-4 rounded-lg text-center bg-gray-100 border-b-4 border-gray-400 cursor-not-allowed opacity-50 flex flex-col items-center justify-center space-y-2">
                        <i class="fas fa-coins text-3xl text-gray-500"></i>
                        <span class="font-semibold text-gray-500">Finance Unit</span>
                        <span class="text-xs text-gray-400">(Access Disabled)</span>
                    </div>

                    <div class="col-span-full mt-4 text-center">
                        {{-- Option 7: Guest (Stay on page / Close Modal) --}}
                        <button id="closeModalBtn" type="button"
                            class="mt-2 text-sm text-gray-500 hover:text-minsu-green transition duration-150 font-semibold">
                            Continue as Guest (Close Pop-up)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('accessModal');
                // The content card is the direct child div of the modal
                const modalContent = modal.querySelector('div:last-child'); 
                const closeBtn = document.getElementById('closeModalBtn');

                // Function to show the modal with transitions
                function showModal() {
                    modal.classList.remove('hidden'); // Make it visible
                    setTimeout(() => {
                        modal.classList.add('opacity-100'); // Fade in overlay
                        modalContent.classList.remove('scale-95'); // Scale up content
                    }, 10); 
                }

                // Function to hide the modal with transitions
                function hideModal() {
                    modal.classList.remove('opacity-100'); // Fade out overlay
                    modalContent.classList.add('scale-95'); // Scale down content
                    
                    // Hide the modal completely after the transition ends (300ms)
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 300);
                }

                // Auto-open on page load if user is a guest
                showModal();

                // Close button listener
                closeBtn.addEventListener('click', hideModal);

                // Re-wire the main 'Get Started' button in the Hero section to open the modal
                const mainAccessButton = document.querySelector('.hero-access-btn');
                if (mainAccessButton) {
                    mainAccessButton.addEventListener('click', (e) => {
                        e.preventDefault(); 
                        showModal();
                    });
                }
            });
        </script>
    @endguest

</body>

</html>