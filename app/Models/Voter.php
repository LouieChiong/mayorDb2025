<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'id');
    }

    public function leader()
    {
        return $this->belongsTo(Leader::class, 'leader_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name},  {$this->first_name}";
    }
}
