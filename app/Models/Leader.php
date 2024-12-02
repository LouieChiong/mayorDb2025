<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leader extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }

    public function voters()
    {
        return $this->hasMany(Voter::class, 'leader_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name},  {$this->first_name} {$this->middle_name}";
    }
}
