

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - MinSU ATS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'minsu-green': '#145a32',
                        'minsu-gold': '#f1c40f',
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
            /* IMPROVED BACKGROUND: Apply the MinSU gradient to the entire body */
            background: linear-gradient(135deg, #145a32 0%, #1a7a42 70%, #f1c40f 100%); 
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Card remains the same, but now it floats on the gradient background -->
<div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 md:p-10 border-t-4 border-minsu-green animate-fade-in">
    
    <div class="text-center mb-8">
        <!-- ... rest of the login form content ... -->
        <div class="mx-auto w-16 h-16 bg-minsu-gold rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-minsu-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-minsu-green mb-1">Welcome Back!</h2>
        <p class="text-gray-500">Sign in to your MinSU Requisitioner Account</p>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Error Message (Validation or Auth Failed) --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
        @csrf
        
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-minsu-green focus:ring-minsu-green focus:ring-1 sm:text-sm" required value="{{ old('email') }}" autofocus>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-minsu-green focus:ring-minsu-green focus:ring-1 sm:text-sm" required>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-minsu-green border-gray-300 rounded focus:ring-minsu-green">
                <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
            </div>
            {{-- Optional: Add a 'Forgot Password' link if implemented later --}}
            {{-- <a href="#" class="text-sm text-minsu-green hover:text-minsu-gold transition duration-150">Forgot password?</a> --}}
        </div>

        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-lg font-bold text-minsu-green bg-minsu-gold hover:bg-yellow-400 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-minsu-gold">
            Login
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
        Don't have an account? 
        <a href="{{ route('register.form') }}" class="font-medium text-minsu-green hover:text-minsu-gold transition duration-150">Register here</a>
    </p>

    <p class="text-center text-xs text-gray-400 mt-4">
        <a href="{{ url('/') }}" class="hover:text-minsu-green">← Back to Homepage</a>
    </p>
</div>

</body>
</html>