@extends('layouts.user')

@section('title', 'New Asset Requisition')

@section('content')
<div class="py-4 max-w-3xl mx-auto">
    <h2 class="text-3xl font-bold text-minsu-green mb-6">Submit New Asset Request</h2>
    
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md">{{ session('success') }}</div>
    @endif

    <form action="{{ route('user.requests.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Category --}}
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category (Optional)</label>
                <select name="category_id" id="category_id"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-requisitioner focus:border-requisitioner">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Priority --}}
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority <span class="text-red-500">*</span></label>
                <select name="priority" id="priority" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-requisitioner focus:border-requisitioner">
                    @foreach ($priorities as $p)
                        <option value="{{ $p }}" {{ old('priority', 'Medium') == $p ? 'selected' : '' }}>
                            {{ $p }}
                        </option>
                    @endforeach
                </select>
                @error('priority') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Item Description --}}
            <div class="md:col-span-2">
                <label for="item_description" class="block text-sm font-medium text-gray-700">Item Description (e.g., HP ProBook Laptop, Office Chair - Ergonomic) <span class="text-red-500">*</span></label>
                <input type="text" name="item_description" id="item_description" value="{{ old('item_description') }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-requisitioner focus:border-requisitioner">
                @error('item_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Quantity --}}
            <div class="md:col-span-2">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity <span class="text-red-500">*</span></label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" required min="1"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-requisitioner focus:border-requisitioner">
                @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Reason --}}
            <div class="md:col-span-2">
                <label for="reason" class="block text-sm font-medium text-gray-700">Justification / Reason for Request <span class="text-red-500">*</span></label>
                <textarea name="reason" id="reason" rows="4" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-requisitioner focus:border-requisitioner">{{ old('reason') }}</textarea>
                @error('reason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
            <button type="submit" class="bg-requisitioner text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-600 transition duration-150 shadow-lg flex items-center space-x-2">
                <i class="fas fa-paper-plane"></i> <span>Submit Requisition</span>
            </button>
        </div>
    </form>
</div>
@endsection