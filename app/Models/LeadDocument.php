<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadDocument extends Model
{
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
