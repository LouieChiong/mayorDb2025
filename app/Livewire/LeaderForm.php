<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Leader;
use Livewire\Component;

class LeaderForm extends Component
{
    public $barangay;
    public $barangays;
    public $purok_name;
    public $precinct;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $puroks = [];
    public $precincts = [];

    public function mount()
    {
        $this->barangays = Barangay::all();
    }
    // Hook for when a property starts updating
    public function updatingBarangay( $value)
    {
        $this->barangay = $value;
        $this->precincts = [];
        $this->reset('purok_name', 'precinct');
        $this->puroks = Barangay::where('barangay_name', '=', $value)
            ->get()
            ->unique('purok_name')
            ->pluck('purok_name');
    }

    public function submit()
    {
        // Validation
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'barangay' => 'required',
            'purok_name' => 'required_with:barangay',
            'precinct' => 'required_with:barangay,purok_name',
        ]);

        $barangay = Barangay::where('barangay_name', '=', $this->barangay)
            ->where('purok_name','=', $this->purok_name)
            ->first();

        $leader = Leader::where('first_name', '=', $this->first_name)
            ->where('last_name', '=', $this->last_name)
            ->get();

        if ($leader->isNotEmpty()) {
            return redirect()->to(request()->header('Referer'))->with('error', 'Leader already exists!');
        }

        // Save the data to the database
        Leader::create([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'precinct' => $this->precinct,
            'barangay_id' => $barangay->id,
        ]);

        // Reset the form fields
        $this->reset(['first_name', 'middle_name', 'last_name', 'barangay', 'purok_name', 'precinct']);

        return redirect()->to(request()->header('Referer'))->with('success', 'Barangay registered successfully!');
    }

    public function render()
    {
        return view('livewire.leader-form');
    }
}
