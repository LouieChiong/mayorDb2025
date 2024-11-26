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
    public $editVoterId;
    public $first_name = '';
    public $last_name = '';
    public $barangay = '';
    public $purok = '';
    public $precinct = '';
    public $status = '';
    public $barangays = [];
    public $puroks = [];
    public $precincts = [];
    public $isModalOpen = false;
    public $edit_barangay = '';
    public $edit_purok = '';
    public $edit_precinct = '';
    public $edit_status = '';

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
            ->unique();
    }

    public function updatingPurok($value)
    {
        $this->reset('precinct');
        $this->precincts = Barangay::where('purok_name', '=', $value)
            ->where('barangay_name', '=', $this->barangay)
            ->get()
            ->pluck('precinct')
            ->unique();
    }

    // Hook for when a property starts updating
    public function updatingEditBarangay($value)
    {
        $this->barangay = $value;
        $this->reset('purok', 'precinct');
        $this->puroks = Barangay::where('barangay_name', '=', $value)
            ->get()
            ->pluck('purok_name')
            ->unique();
    }

    public function updatingEditPurok($value)
    {
        $this->reset('precinct');
        $this->precincts = Barangay::where('purok_name', '=', $value)
            ->where('barangay_name', '=', $this->barangay)
            ->get()
            ->pluck('precinct')
            ->unique();
    }

    public function editVoter($id)
    {
        $this->isModalOpen = true;
        $voter = Voter::find($id);
        $this->editVoterId  = $voter->id;
        $this->status = $voter->is_alive;
        $this->dispatch('openModal', [
            'first_name' => $voter->first_name,
            'last_name' => $voter->last_name,
            'is_alive' => $voter->is_alive,
        ]);
    }

    public function updateVoter()
    {
        $this->validate([
            'edit_barangay' => 'nullable',
            'edit_purok' => 'required_with:edit_barangay',
            'edit_precinct' => 'required_with:edit_purok',
        ]);

        $voter = Voter::find($this->editVoterId);

        if($this->edit_status != '') {
            $voter->is_alive = (int)$this->edit_status;
        }

        if ($this->edit_barangay != null) {
            $voter->barangay_id =  Barangay::where('barangay_name', '=', $this->edit_barangay)
                ->where('purok_name', '=', $this->edit_purok)
                ->where('precinct', '=', $this->edit_precinct)
                ->get()->first()->id;
        }

        $voter->save();

        session()->flash('success', 'Voter updated successfully!');
        $this->reset(['edit_barangay', 'edit_purok', 'edit_precinct']);

        // Refresh the list and close the modal
        $this->refreshVoterList();;
        $this->dispatch('closeModal');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset('first_name', 'last_name', 'edit_barangay', 'edit_purok', 'edit_precinct');
        $this->dispatch('closeModal');
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

        $voter = Voter::where('first_name', $this->first_name)->where('last_name', $this->last_name)->first();

        if ($voter) {
            return redirect()
                ->to(request()->header('Referer'))
                ->with('duplicate-error', 'Voter already exists!')
                ->with('data', [
                    'first_name' => $voter->first_name,
                    'last_name' => $voter->last_name,
                    'barangay' => $voter->barangay->barangay_name ?? 'not assigned',
                    'purok' => $voter->barangay->purok_name ?? 'not assigned',
                    'precinct' => $voter->barangay->precinct ?? 'not assigned',
                    'leader' => $voter->leader->name ,
                ]);
        }

        Voter::create([
            'leader_id' => $this->leader->id,
            'barangay_id' => $barangay->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'is_alive' => (int)$this->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->reset('first_name', 'last_name', 'barangay', 'purok', 'precinct', 'status');
        $this->refreshVoterList();
        return redirect()->to(request()->header('Referer'))->with('success', 'Voter registered successfully!');
    }

    public function deleteVoter($voterId)
    {
        $voter = Voter::find($voterId);
        $voter->delete();
        session()->flash('success', 'Voter deleted successfully!');
        $this->refreshVoterList();
    }

    public function render()
    {
        return view('livewire.voter-list');
    }
}
