<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barangay extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function leaders(): HasMany
    {
        return $this->hasMany(Leader::class);
    }

    public function voters(): HasMany
    {
        return $this->hasMany(Voter::class);
    }
}
