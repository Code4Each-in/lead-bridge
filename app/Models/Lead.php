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
        'assigned_to',
        'assigned_qa_id',
        'assigned_manager_id',
        'previous_ae_id',
        'stage',
        'end_date',
    ];

    // AE (many-to-many - ONLY for AE history if you want)
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

    public function leadNotes()
    {
        return $this->hasMany(LeadNote::class);
    }

    public function leadDocuments()
    {
        return $this->hasMany(LeadDocument::class);
    }

    public function qaUser()
    {
        return $this->belongsTo(User::class, 'assigned_qa_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'assigned_manager_id');
    }
    public function involvedUsers()
    {
        $users = collect();

        // 1. pivot users
        $users = $users->merge($this->users);

        // 2. assigned AE
        if ($this->assigned_to) {
            $users->push(User::find($this->assigned_to));
        }

        // 3. QA
        if ($this->assigned_qa_id) {
            $users->push(User::find($this->assigned_qa_id));
        }

        // 4. Manager
        if ($this->assigned_manager_id) {
            $users->push(User::find($this->assigned_manager_id));
        }

        // 5. creator
        if ($this->created_by) {
            $users->push(User::find($this->created_by));
        }

        // remove null + duplicates
        return $users->filter()->unique('id');
    }
}
