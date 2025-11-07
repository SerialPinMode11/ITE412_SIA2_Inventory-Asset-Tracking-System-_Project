@extends('layouts.admin')

@section('title', 'Admin Panel')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-danger">Welcome, Administrator!</h2>
    <p>You are logged in as <strong>{{ Auth::user()->role }}</strong>.</p>

    <div class="p-3 mt-3 border border-danger rounded bg-light">
        <p>This is the central <strong>Administration Panel</strong>.</p>
        <p class="fw-bold text-danger">You have full system access. Proceed with caution.</p>
        <hr>
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="btn btn-outline-danger">
            Logout
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
            @csrf
        </form>
    </div>
</div>
@endsection
