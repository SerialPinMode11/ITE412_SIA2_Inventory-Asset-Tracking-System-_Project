@extends('layouts.viewer')

@section('title', 'Viewer Report')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-warning">Welcome, Data Viewer!</h2>
    <p>You are logged in as <strong>{{ Auth::user()->role }}</strong>.</p>

    <div class="p-3 mt-3 border border-warning rounded bg-light">
        <p>This is the <strong>Viewer Report Page</strong>.</p>
        <p class="fw-bold text-dark">Only users with Viewer or Admin roles can access this section.</p>
    </div>
</div>
@endsection
