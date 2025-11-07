<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_tag',
        'item_name',
        'category_id',
        'model',
        'serial_number',
        'supplier_id',
        'date_acquired',
        'acquisition_cost',
        'condition',
        'status',
        'location_id',
        'custodian_id',
        'inspection_report_id',
        'warranty_expiry',
        'remarks',
    ];

    protected $casts = [
        'date_acquired' => 'date',
        'warranty_expiry' => 'date',
    ];

    // Define Relationships (for dropdowns and data display)
    public function category()
    {
        return $this->belongsTo(AssetCategory::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function custodian()
    {
        return $this->belongsTo(Employee::class, 'custodian_id');
    }

    public function inspectionReport()
    {
        return $this->belongsTo(InspectionReport::class);
    }
}
