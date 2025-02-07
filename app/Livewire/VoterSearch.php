<?php
namespace App\Livewire;

use App\Models\Voter;
use App\Models\Barangay;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class VoterSearch extends Component
{
    use WithPagination;

    public $perPage = 10; // Number of rows per page
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

    // Reset pagination when filters change
    public function updating($property)
    {
        $this->resetPage();
    }

    public function updatingBarangay($value)
    {
        $this->barangay = $value;
        $this->precincts = [];
        $this->reset('purok_name', 'precinct');
        $this->puroks = Barangay::where('barangay_name', '=', $value)
            ->get()
            ->unique('purok_name')
            ->pluck('purok_name');
    }

    public function filterSearch()
    {
        $this->resetPage();
    }

    public function downloadPDF()
    {
        $query = Voter::query();

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
                $query->where('barangay_name', $this->barangay);
            });
        }

        if (!empty($this->purok_name)) {
            $query->whereHas('barangay', function ($query) {
                $query->where('purok_name', $this->purok_name);
            });
        }

        if (!empty($this->precinct)) {
            $query->where('precinct', '=', $this->precinct);
        }

        // Fetch filtered data
        $voters = $query->orderBy('barangay_id')->get();

        // Generate PDF
        $pdf = Pdf::loadView('download-all-voters', compact('voters'))->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->stream()),
            'search-voters-list.pdf'
        );
    }

    public function resetFilter()
    {
        $this->reset('first_name', 'last_name', 'middle_name', 'barangay', 'purok_name', 'precinct');
        $this->resetPage();
    }

    public function render()
    {
        $query = Voter::query();

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
                $query->where('barangay_name', $this->barangay);
            });
        }

        if (!empty($this->purok_name)) {
            $query->whereHas('barangay', function ($query) {
                $query->where('purok_name', $this->purok_name);
            });
        }

        if (!empty($this->precinct)) {
            $query->where('precinct', '=', $this->precinct);
        }

        $voters = $query->orderBy('last_name')->paginate($this->perPage);

        return view('livewire.voter-search', compact('voters'));
    }
}
