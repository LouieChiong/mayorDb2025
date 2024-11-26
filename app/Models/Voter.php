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
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }
}