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
    public $first_name ='';
    public $middle_name = '';
    public $last_name = '';

    public function mount() {
        $this->barangays = Barangay::all()->pluck(['barangay_name'])->unique();
    }

    public function updatedBarangay($value) {
        $this->reset(['puroks', 'precincts']);
        $this->barangay = $value;
        $this->puroks = Barangay::where('barangay_name', $value)->pluck('purok_name')->unique();
    }

    public function render()
    {
        return view('livewire.barangay-dropdown');
    }

    public function searchLeaders() {
        $parameter = [];

        if($this->purok) {
            $parameter['purok'] = $this->purok;
        };

        if($this->barangay) {
            $parameter['barangay'] = $this->barangay;
        }

        if($this->first_name) {
            $parameter['first_name'] = $this->first_name;
        }

        if($this->middle_name) {
            $parameter['middle_name'] = $this->middle_name;
        }

        if($this->last_name) {
            $parameter['last_name'] = $this->last_name;
        }

        return redirect()->route('leader-search', $parameter);
    }

    public function searchVoters()
    {
        $parameter = [];

        if ($this->purok) {
            $parameter['purok'] = $this->purok;
        };

        if ($this->barangay) {
            $parameter['barangay'] = $this->barangay;
        }

        if ($this->first_name) {
            $parameter['first_name'] = $this->first_name;
        }

        if ($this->middle_name) {
            $parameter['middle_name'] = $this->middle_name;
        }

        if ($this->last_name) {
            $parameter['last_name'] = $this->last_name;
        }

        return redirect()->route('voter-search', $parameter);
    }
}
