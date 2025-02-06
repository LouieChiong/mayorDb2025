<?php
namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Leader;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class LeaderSearch extends Component
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
        $query = Leader::query();

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
        $leaders = $query->orderBy('barangay_id')->get();

        // Generate PDF
        $pdf = Pdf::loadView('download-all-leaders', compact('leaders'))->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->stream()),
            'search-leader-list.pdf'
        );
    }

    public function resetFilter()
    {
        $this->reset('first_name', 'last_name', 'middle_name', 'barangay', 'purok_name', 'precinct');
        $this->resetPage();
    }

    public function render()
    {
        $query = Leader::query();

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

        $leaders = $query->orderBy('last_name')->paginate($this->perPage);

        return view('livewire.leader-search', compact('leaders'));
    }
}
