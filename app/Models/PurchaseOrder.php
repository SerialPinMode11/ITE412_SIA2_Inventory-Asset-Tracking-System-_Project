<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
     use HasFactory;
    protected $fillable = ['po_number', 'supplier_id', 'order_date', 'total_amount', 'delivery_schedule', 'delivery_status', 'payment_status_id', 'notes'];

    protected $casts = [
        'order_date' => 'date',
        'delivery_schedule' => 'date',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
    public function paymentStatus() {
        return $this->belongsTo(PaymentStatus::class);
    }

     // Add this to get all inspection reports related to this PO
    public function inspectionReports()
    {
        // NOTE: In a perfect system, this would be a one-to-many relationship via item line-items,
        // but for simplicity, we link all reports that share this PO ID.
        return $this->hasMany(InspectionReport::class);
    }
}
