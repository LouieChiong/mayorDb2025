<?php

namespace App\Livewire;

use App\Models\Barangay;
use Livewire\Component;

class BarangayDropdown extends Component
{
    public $barangay;
    public $purok;
    public $precinct;
    public $barangays = [];
    public $puroks = [];
    public $precincts = [];

    public function mount() {
        $this->barangays = Barangay::all()->pluck(['barangay_name'])->unique('barangay_name');
    }

    public function updatedBarangay($value) {
        $this->reset(['puroks', 'precincts']);
        $this->barangay = $value;
        $this->puroks = Barangay::where('barangay_name', $value)->pluck('purok_name')->unique();
    }

    public function updatedPurok($value) {
        $this->reset('precincts');
        $this->precincts = Barangay::where('barangay_name', $this->barangay)->where('purok_name', $value)->pluck('precinct')->unique();
    }

    public function render()
    {
        return view('livewire.barangay-dropdown');
    }
}
