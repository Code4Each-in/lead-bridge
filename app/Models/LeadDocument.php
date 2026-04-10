<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadDocument extends Model
{
    protected $fillable = [
        'lead_id',
        'uploaded_by',
        'file',
        'file_name',
        'file_type',
        'file_size'
    ];
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
