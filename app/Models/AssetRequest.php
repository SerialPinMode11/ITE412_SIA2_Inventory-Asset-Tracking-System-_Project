<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'item_description',
        'quantity',
        'reason',
        'priority',
        'status',
        'approved_by_user_id',
        'admin_notes',
    ];

    // The Requisitioner (User who made the request)
    public function requester()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // The Admin/Supply Officer who approved/rejected it
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }

    public function category()
    {
        return $this->belongsTo(AssetCategory::class);
    }
}
