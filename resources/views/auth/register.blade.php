

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - MinSU ATS</title>
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

<div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 md:p-10 border-t-4 border-minsu-green animate-fade-in">
    
    <div class="text-center mb-8">
        <!-- ... rest of the register form content ... -->
        <div class="mx-auto w-16 h-16 bg-minsu-gold rounded-full flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-minsu-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14c-6.143 0-8 2.2-8 4v2h16v-2c0-1.8-1.857-4-8-4z"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-minsu-green mb-1">Join the System</h2>
        <p class="text-gray-500">Create your MinSU Requisitioner Account</p>
    </div>

    {{-- Error Message (Validation) --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="mb-0 list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}" class="space-y-6">
        @csrf
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-minsu-green focus:ring-minsu-green focus:ring-1 sm:text-sm" required value="{{ old('name') }}" autofocus>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-minsu-green focus:ring-minsu-green focus:ring-1 sm:text-sm" required value="{{ old('email') }}">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-minsu-green focus:ring-minsu-green focus:ring-1 sm:text-sm" required>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-minsu-green focus:ring-minsu-green focus:ring-1 sm:text-sm" required>
        </div>

        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-lg font-bold text-minsu-green bg-minsu-gold hover:bg-yellow-400 transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-minsu-gold">
            Register
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
        Already have an account? 
        <a href="{{ route('login.form') }}" class="font-medium text-minsu-green hover:text-minsu-gold transition duration-150">Login here</a>
    </p>

    <p class="text-center text-xs text-gray-400 mt-4">
        <a href="{{ url('/') }}" class="hover:text-minsu-green">← Back to Homepage</a>
    </p>
</div>

</body>
</html>