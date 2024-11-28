<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Leader;
use Livewire\Component;

class LeaderList extends Component
{
    public $leaders;
    public $barangays;
    public $edit_barangay;
    public $edit_purok_name;
    public $edit_precinct;
    public $edit_leader_name;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $puroks = [];
    public $precincts = [];
    public $barangay_name = '';
    public $purok_name = '';
    public $precinct = '';
    public $leader_id;
    public $leader_name;
    public $isModalOpen = false;

    public function mount()
    {
        $this->barangays = Barangay::all()->unique('barangay_name');
        $this->refreshLeaders();
    }

    public function refreshLeaders()
    {
        $this->leaders = Leader::all();
    }

    // Hook for when a property starts updating
    public function updatingEditBarangay($value)
    {
        if ($value == null) {
            $this->puroks = [];
            $this->precincts = [];
        } else {
            $this->edit_barangay = $value;
            $this->precincts = [];
            $this->reset('edit_purok_name', 'edit_precinct');
            $this->puroks = Barangay::where('barangay_name', '=', $value)
                ->get()
                ->unique('purok_name')
                ->pluck('purok_name');
        }
    }

    public function editL1eader($id)
    {
        $this->isModalOpen = true;
        $leader = Leader::find($id);
        $this->leader_id = $leader->id;
        $this->first_name = $leader->first_name;
        $this->last_name = $leader->last_name;
        $this->middle_name = $leader->middle_name;
        $this->barangay_name = $leader->barangay->barangay_name;
        $this->purok_name = $leader->barangay->purok_name;
        $this->precinct = $leader->precinct;

        $this->dispatch('openModal', [
            'first_name' => $this->first_name,
            'last_name`' => $this->last_name,
            'middle_name' => $this->middle_name,
            'barangay_name' => $this->barangay_name,
            'purok_name' => $this->purok_name,
            'precinct' => $this->precinct,
        ]);
    }

    public function updateLeader()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'edit_barangay' => 'nullable',
            'edit_purok_name' => 'required_with:edit_barangay',
            'edit_precinct' => 'required_with:edit_purok_name',
        ]);

        $leader = Leader::find($this->leader_id);
        $leader->first_name = $this->first_name;
        $leader->last_name = $this->last_name;
        $leader->middle_name = $this->middle_name;
        $leader->precinct = $this->edit_precinct;

        if($this->edit_barangay != null) {
            $leader->barangay_id =  Barangay::where('barangay_name', '=', $this->edit_barangay)
                ->where('purok_name', '=', $this->edit_purok_name)
                ->get()->first()->id;
        }

        $leader->save();

        session()->flash('success', 'Leader updated successfully!');
        $this->reset(['edit_barangay', 'edit_purok_name', 'edit_precinct', 'first_name', 'last_name', 'middle_name', 'precinct']);

        // Refresh the list and close the modal
        $this->refreshLeaders();
        $this->dispatch('closeModal');
    }

    public function deleteLeader($id)
    {
        Leader::find($id)->delete();
        session()->flash('success', 'Leader updated successfully!');
        $this->refreshLeaders();
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset('edit_barangay', 'leader_name', 'leader_id');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.leader-list');
    }
}
