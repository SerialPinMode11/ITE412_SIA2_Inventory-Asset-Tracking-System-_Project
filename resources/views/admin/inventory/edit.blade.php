@extends('layouts.admin')

@section('title', 'Edit Asset: ' . $asset->asset_tag)

@section('content')
<div class="py-4">
    <h2 class="text-3xl font-bold text-minsu-green mb-6">Edit Physical Asset: <span class="text-minsu-gold">{{ $asset->asset_tag }}</span></h2>
    
    <form action="{{ route('admin.inventory.update', $asset) }}" method="POST">
        @method('PUT')
        @include('admin.inventory._form', ['asset' => $asset])
    </form>
</div>
@endsection
