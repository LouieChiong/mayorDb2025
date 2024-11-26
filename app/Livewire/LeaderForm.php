<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Leader;
use Livewire\Component;

class LeaderForm extends Component
{
    public $barangay;
    public $barangays;
    public $name;
    public $purok_name;
    public $precinct;
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

    public function updatingPurokName($value)
    {
        $this->reset('precinct');
        $this->precincts = Barangay::where('purok_name', '=', $value)
            ->where('barangay_name', '=', $this->barangay)
            ->get()
            ->unique('precinct')
            ->pluck('precinct');
    }

    public function submit()
    {
        // Validation
        $this->validate([
            'name' => 'required',
            'barangay' => 'required',
            'purok_name' => 'required',
            'precinct' => 'required',
        ]);

        $barangay = Barangay::where('barangay_name', '=', $this->barangay)
            ->where('purok_name','=', $this->purok_name)
            ->where('precinct','=', $this->precinct)
            ->first();

        $leader = Leader::where('name', '=', $this->name)->get();

        if ($leader->isNotEmpty()) {
            return redirect()->to(request()->header('Referer'))->with('error', 'Leader already exists!');
        }

        // Save the data to the database
        Leader::create([
            'name' => $this->name,
            'position' => 'Leader',
            'barangay_id' => $barangay->id,
        ]);

        // Reset the form fields
        $this->reset(['name', 'barangay', 'purok_name', 'precinct']);

        return redirect()->to(request()->header('Referer'))->with('success', 'Barangay registered successfully!');
    }

    public function render()
    {
        return view('livewire.leader-form');
    }
}
