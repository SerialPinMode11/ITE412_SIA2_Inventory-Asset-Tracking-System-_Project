@extends('layouts.admin')

@section('title', 'Admin Panel')

@section('content')

<!-- Main Container -->
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    

    <!-- 2. WELCOME CARD (The White Area) -->
    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        
        <!-- Header Section of Card -->
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Welcome, Administrator!
                </h2>
                <p class="text-sm text-gray-500">Central Administration Panel</p>
            </div>
            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                System Active
            </span>
        </div>

        <!-- Body Content -->
        <div class="p-6">
            <div class="text-gray-700">
                You are logged in as an <span class="font-semibold">Administrator</span>. From this panel, you can manage physical asset inventory, oversee tracking asset, and monitor inspectorate activity. Use the navigation menu to access different administrative functions.
            </div>
        </div>
    </div>
</div>

@endsection