<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionReport extends Model
{
    use HasFactory;
    protected $fillable = ['report_number', 'inspection_date', 'result', 'purchase_order_id'];
    
    // Add this to allow linking the report back to the PO
    public function purchaseOrder() 
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
