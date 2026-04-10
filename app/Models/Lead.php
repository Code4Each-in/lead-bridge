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
        'created_by',
        'start_date',
        'end_date',
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
    public function documents()
    {
        return $this->hasMany(LeadDocument::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function qaUsers()
    {
        // Get users assigned to this lead who have the QA role
        return $this->users()->whereHas('role', function($q) {
            $q->where('name', 'QA');
        });

    }
    public function leadNotes()
    {
        return $this->hasMany(LeadNote::class);
    }
        public function leadDocuments()
        {
            return $this->hasMany(LeadDocument::class);
        }

}
