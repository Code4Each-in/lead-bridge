<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'company',
        'city',
        'source',
        'status',
        'agency_id',
        'notes',
        'documents',
    ];

    /**
     * Many-to-many: assigned users via lead_user pivot.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'lead_user');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }
}
