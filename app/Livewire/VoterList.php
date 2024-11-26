<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Leader;
use App\Models\Voter;
use Livewire\Component;

class VoterList extends Component
{
    public $leaderId;
    public $leader;
    public $voters;
    public $first_name = '';
    public $last_name = '';
    public $barangay = '';
    public $purok = '';
    public $precinct = '';
    public $status = '';
    public $barangays = [];
    public $puroks = [];
    public $precincts = [];

    public function mount($leaderId)
    {
        $this->leader = Leader::find($leaderId);
        $this->refreshVoterList();
        $this->barangays = Barangay::all()->pluck('barangay_name')->unique();
    }

    public function refreshVoterList()
    {
        $this->voters = Voter::where('leader_id', $this->leader->id)->get();
    }

    // Hook for when a property starts updating
    public function updatingBarangay($value)
    {
        $this->barangay = $value;
        $this->reset('purok', 'precinct');
        $this->puroks = Barangay::where('barangay_name', '=', $value)
            ->get()
            ->pluck('purok_name')
            ->unique('purok_name');
    }

    public function updatingPurok($value)
    {
        $this->reset('precinct');
        $this->precincts = Barangay::where('purok_name', '=', $value)
            ->where('barangay_name', '=', $this->barangay)
            ->get()
            ->pluck('precinct')
            ->unique('precinct');
    }

    public function submit()
    {
        // Validation
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'barangay' => 'required',
            'purok' => 'required_with:barangay',
            'precinct' => 'required_with:purok',
        ]);

        $barangay = Barangay::where('barangay_name', '=', $this->barangay)
            ->where('purok_name', '=', $this->purok)
            ->where('precinct', '=', $this->precinct)
            ->first();

        Voter::create([
            'leader_id' => $this->leader->id,
            'barangay_id' => $barangay->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'is_alive' => $this->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->reset('first_name', 'last_name', 'barangay', 'purok', 'precinct', 'status');
        $this->refreshVoterList();
        return redirect()->to(request()->header('Referer'))->with('success', 'Voter registered successfully!');
    }

    public function render()
    {
        return view('livewire.voter-list');
    }
}
