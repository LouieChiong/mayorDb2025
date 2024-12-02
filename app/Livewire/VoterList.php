<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Leader;
use App\Models\Voter;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class VoterList extends Component
{
    public $leaderId;
    public $leader;
    public $voters;
    public $editVoterId;
    public $first_name = '';
    public $last_name = '';
    public $middle_name = '';
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
    public $edit_status = 1;
    public $voterList = [];
    public $updateStatus = '';

    public function mount($leaderId)
    {
        $this->leader = Leader::find($leaderId);
        $this->refreshVoterList();
        $this->barangays = Barangay::all()->pluck('barangay_name')->unique();
    }

    public function refreshVoterList()
    {
        $this->voters = Voter::where('leader_id', $this->leader->id)->get()->sortBy(['full_name']);
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

    public function editVoter($id)
    {
        $this->isModalOpen = true;
        $voter = Voter::find($id);
        $this->editVoterId  = $voter->id;
        $this->status = $voter->is_alive;
        $this->dispatch('openModal', [
            'first_name' => $voter->first_name,
            'last_name' => $voter->last_name,
            'middle_name' => $voter->middle_name,
            'precinct' => $voter->precinct,
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
        $voter->precinct = $this->edit_precinct;

        if($this->updateStatus != '') {
            $voter->is_alive = $this->updateStatus === '' ? 1 : (int)$this->updateStatus;
        }

        if ($this->edit_barangay != null) {
            $voter->barangay_id =  Barangay::where('barangay_name', '=', $this->edit_barangay)
                ->where('purok_name', '=', $this->edit_purok)
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
            'middle_name' => 'required',
            'barangay' => 'required',
            'purok' => 'required_with:barangay',
            'precinct' => 'required_with:purok',
        ]);

        $barangay = Barangay::where('barangay_name', '=', $this->barangay)
            ->where('purok_name', '=', $this->purok)
            ->first();

        $voter = Voter::where('first_name', $this->first_name)->where('last_name', $this->last_name)->first();

        if ($voter) {
            return redirect()
                ->to(request()->header('Referer'))
                ->with('duplicate-error', 'Voter already exists!')
                ->with('data', [
                    'first_name' => $voter->first_name,
                    'last_name' => $voter->last_name,
                    'middle_name' => $voter->middle_name,
                    'barangay' => optional($voter->barangay)->barangay_name ?? 'Not Assigned',
                    'purok' => optional($voter->barangay)->purok_name ?? 'Not Assigned',
                    'precinct' => $voter->precinct ?? 'Not Assigned',
                    'leader' => optional($voter->leader)->full_name ?? 'Not Assigned',
                ]);
        }

        Voter::create([
            'leader_id' => $this->leader->id,
            'barangay_id' => $barangay->id,
            'precinct' => $this->precinct,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'is_alive' =>  $this->status === '' ? 1 : (int)$this->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->reset('first_name', 'last_name', 'middle_name', 'barangay', 'purok', 'precinct');
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

    public function downloadPDF()
    {

        $data = [
            'title' => 'Voter List',
            'leader' => $this->leader,
            'voters' => $this->voters,
        ];

        $pdf = Pdf::loadView('download-voters', $data)->setPaper('a4', 'portrait');

        // Download PDF file
        return response()->streamDownload(
            fn() => print($pdf->stream()),
            'voter-list.pdf'
        );
    }

    public function render()
    {
        return view('livewire.voter-list');
    }
}
