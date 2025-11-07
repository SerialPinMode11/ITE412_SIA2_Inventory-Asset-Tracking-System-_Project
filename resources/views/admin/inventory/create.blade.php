@extends('layouts.admin')

@section('title', 'Add New Asset')

@section('content')
<div class="py-4">
    <h2 class="text-3xl font-bold text-minsu-green mb-6">Create New Physical Asset</h2>
    
    {{-- ADD THIS BLOCK FOR ERROR MESSAGES --}}
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif
    
    <form action="{{ route('admin.inventory.store') }}" method="POST">
        {{-- FIX: Pass an empty array or an uninitialized variable to _form to prevent the error --}}
        @include('admin.inventory._form', ['asset' => null])
    </form>
</div>
@endsection