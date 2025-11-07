{{-- resources/views/admin/inventory/_form.blade.php --}}

@csrf

{{-- Initialize $asset to a new, empty model instance if it is null (used in create view) --}}
@php
    $asset = $asset ?? new App\Models\PhysicalAsset();
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="md:col-span-3 pb-4 mb-4 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-minsu-green">Asset Identification</h3>
    </div>

    {{-- 1. Asset Tag and Item Name --}}
    <div class="md:col-span-1">
        <label for="asset_tag" class="block text-sm font-medium text-gray-700">Asset Tag / Property Number <span class="text-red-500">*</span></label>
        <input type="text" name="asset_tag" id="asset_tag" value="{{ old('asset_tag', $asset->asset_tag ?? '') }}" required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
        @error('asset_tag') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-2">
        <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name / Description <span class="text-red-500">*</span></label>
        <input type="text" name="item_name" id="item_name" value="{{ old('item_name', $asset->item_name ?? '') }}" required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
        @error('item_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- 2. Category and Model/Serial --}}
    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
        <select name="category_id" id="category_id" required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
            <option value="">-- Select Category --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" 
                    {{ old('category_id', $asset->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
        <input type="text" name="model" id="model" value="{{ old('model', $asset->model ?? '') }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
    </div>
    <div>
        <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number</label>
        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $asset->serial_number ?? '') }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
    </div>

    <div class="md:col-span-3 pt-6 pb-4 mb-4 border-b border-gray-200 border-t">
        <h3 class="text-xl font-semibold text-minsu-green">Acquisition & Financial</h3>
    </div>

    {{-- 3. Acquisition Details --}}
    <div>
        <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
        <select name="supplier_id" id="supplier_id"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
            <option value="">-- Select Supplier (Optional) --</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" 
                    {{ old('supplier_id', $asset->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="date_acquired" class="block text-sm font-medium text-gray-700">Date Acquired <span class="text-red-500">*</span></label>
        <input type="date" name="date_acquired" id="date_acquired" 
            value="{{ old('date_acquired', $asset->date_acquired ? $asset->date_acquired->format('Y-m-d') : now()->format('Y-m-d')) }}" required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
    </div>
    <div>
        <label for="acquisition_cost" class="block text-sm font-medium text-gray-700">Acquisition Cost (₱)</label>
        <input type="number" step="0.01" name="acquisition_cost" id="acquisition_cost" value="{{ old('acquisition_cost', $asset->acquisition_cost ?? '') }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
    </div>

    {{-- 4. Status and Condition --}}
    <div>
        <label for="condition" class="block text-sm font-medium text-gray-700">Condition <span class="text-red-500">*</span></label>
        <select name="condition" id="condition" required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
            @foreach ($conditions as $c)
                <option value="{{ $c }}" 
                    {{ old('condition', $asset->condition ?? '') == $c ? 'selected' : '' }}>
                    {{ $c }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
        <select name="status" id="status" required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
            @foreach ($statuses as $s)
                <option value="{{ $s }}" 
                    {{ old('status', $asset->status ?? '') == $s ? 'selected' : '' }}>
                    {{ $s }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="warranty_expiry" class="block text-sm font-medium text-gray-700">Warranty Expiry Date</label>
        <input type="date" name="warranty_expiry" id="warranty_expiry" value="{{ old('warranty_expiry', $asset->warranty_expiry?->format('Y-m-d')) }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
    </div>
    
    <div class="md:col-span-3 pt-6 pb-4 mb-4 border-b border-gray-200 border-t">
        <h3 class="text-xl font-semibold text-minsu-green">Assignment & Documentation</h3>
    </div>
    
    {{-- 5. Location and Custodian --}}
    <div>
        <label for="location_id" class="block text-sm font-medium text-gray-700">Current Location</label>
        <select name="location_id" id="location_id"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
            <option value="">-- Select Location (Optional) --</option>
            @foreach ($locations as $location)
                <option value="{{ $location->id }}" 
                    {{ old('location_id', $asset->location_id ?? '') == $location->id ? 'selected' : '' }}>
                    {{ $location->name }} ({{ $location->building }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-1">
        <label for="custodian_id" class="block text-sm font-medium text-gray-700">Custodian (Employee)</label>
        <select name="custodian_id" id="custodian_id"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
            <option value="">-- Select Custodian (Optional) --</option>
            @foreach ($custodians as $custodian)
                <option value="{{ $custodian->id }}" 
                    {{ old('custodian_id', $asset->custodian_id ?? '') == $custodian->id ? 'selected' : '' }}>
                    {{ $custodian->name }}
                </option>
            @endforeach
        </select>
    </div>
    
    {{-- 6. Inspection Report --}}
    <div>
        <label for="inspection_report_id" class="block text-sm font-medium text-gray-700">Inspection Report</label>
        <select name="inspection_report_id" id="inspection_report_id"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">
            <option value="">-- Select Report (Optional) --</option>
            @foreach ($inspectionReports as $report)
                <option value="{{ $report->id }}" 
                    {{ old('inspection_report_id', $asset->inspection_report_id ?? '') == $report->id ? 'selected' : '' }}>
                    {{ $report->report_number }} ({{ $report->result }})
                </option>
            @endforeach
        </select>
    </div>
    
    {{-- 7. Remarks --}}
    <div class="md:col-span-3">
        <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
        <textarea name="remarks" id="remarks" rows="3"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-minsu-green focus:border-minsu-green">{{ old('remarks', $asset->remarks ?? '') }}</textarea>
    </div>
</div>

<div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
    <button type="submit" class="bg-minsu-green text-white font-bold py-2 px-6 rounded-lg hover:bg-minsu-green/90 transition duration-150 shadow-lg">
        {{ $asset->exists ? 'Update Asset' : 'Create Asset' }}
    </button>
</div>