<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Leader;
use App\Models\Voter;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithPagination;

class VoterList extends Component
{
    use WithPagination;

    public $perPage = 10; // Number of rows per page
    public $leaderId;
    public $leader;
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
    public $edit_barangays = [];
    public $edit_purok = '';
    public $edit_puroks = [];
    public $edit_precinct = '';
    public $edit_status = 1;
    public $voterList = [];
    public $updateStatus = '';
    public $leaders = [];
    public $edit_leader = '';

    public function mount($leaderId)
    {
        $this->leader = Leader::find($leaderId);
        $this->barangays = Barangay::all()->pluck('barangay_name')->unique();
        $this->edit_barangays = Barangay::all()->pluck('barangay_name')->unique();
        $this->leaders = Leader::orderBy('last_name')->get();
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
        $this->reset('purok', 'precinct');
        $this->edit_puroks = Barangay::where('barangay_name', '=', $value)
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
            'edit_purok' => 'required_with:edit_barangay'
        ]);

        $voter = Voter::find($this->editVoterId);

        if($this->updateStatus != '') {
            $voter->is_alive = $this->updateStatus === '' ? 1 : (int)$this->updateStatus;
        }

        if ($this->edit_barangay != null) {
            $voter->barangay_id =  Barangay::where('barangay_name', '=', $this->edit_barangay)
                ->where('purok_name', '=', $this->edit_purok)
                ->get()->first()->id;
        }

        if ($this->edit_precinct != null) {
            $voter->precinct = $this->edit_precinct;
        }

        if ($this->edit_leader != null) {
            $voter->leader_id = $this->edit_leader;
        }

        $voter->save();

        session()->flash('success', 'Voter updated successfully!');

        // Refresh the list and close the modal
        $this->resetPage();;
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

    public function filterSearch()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset('first_name', 'last_name', 'middle_name', 'barangay', 'purok', 'precinct');
        $this->resetPage();
    }

    public function downloadPDF()
    {
        $allVoters = Voter::where('leader_id', $this->leader->id)->orderBy('last_name')->get();

        $data = [
            'title' => 'Voter List',
            'leader' => $this->leader,
            'voters' => $allVoters, // Fetching all voters instead of paginated
        ];

        $pdf = Pdf::loadView('download-voters', $data)->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn() => print($pdf->stream()),
            'voter-list.pdf'
        );
    }

    public function render()
    {
        $query = Voter::where('leader_id', $this->leader->id);

        if (!empty($this->first_name)) {
            $query->where('first_name', 'like', '%' . $this->first_name . '%');
        }

        if (!empty($this->last_name)) {
            $query->where('last_name', 'like', '%' . $this->last_name . '%');
        }

        if (!empty($this->middle_name)) {
            $query->where('middle_name', 'like', '%' . $this->middle_name . '%');
        }

        if (!empty($this->barangay)) {
            $query->whereHas('barangay', function ($query) {
                $query->where('barangay_name', '=', $this->barangay);
            });
        }

        if (!empty($this->purok)) {
            $query->whereHas('barangay', function ($query) {
                $query->where('purok_name', '=', $this->purok);
            });
        }

        if (!empty($this->precinct)) {
            $query->where('precinct', '=', $this->precinct);
        }

        $voters = $query->orderBy('last_name')->paginate($this->perPage);

        return view('livewire.voter-list', compact('voters'));
    }
}
