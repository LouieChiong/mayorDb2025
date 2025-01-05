<?php
namespace App\Livewire;

use App\Models\Barangay;
use Livewire\Component;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\On;

class BarangayList extends Component
{
    use WithFileUploads;

    public $barangay_id;
    public $barangays;
    public $barangay_name;
    public $precinct = '';
    public $purok_name;
    public $file;

    public function mount()
    {
        $this->refreshBarangays();
    }

    public function refreshBarangays()
    {
        $this->barangays = Barangay::all()->sortBy(['barangay_name']);
    }

    #[On('filter-barangay')]
    public function filterBarangay($data)
    {
        $query = Barangay::query();

        if (!empty($data['barangay_name'])) {
            $query->where('barangay_name', 'like', '%' . $data['barangay_name'] . '%');
        }

        $this->barangays = $query->orderBy('barangay_name')->get();
    }

    #[On('download-excel')]
    public function downloadExcel()
    {
        $data = [
            'barangays' => $this->barangays
        ];

        $pdf = Pdf::loadView('download-barangay-list', $data)->setPaper('a4', 'landscape');

        // Download PDF file
        return response()->streamDownload(
            fn() => print($pdf->stream()),
            'barangay-list.pdf'
        );
    }

    #[On('reset-list')]
    public function resetList()
    {
        $this->refreshBarangays();
    }

    public function editBarangay($id)
    {
        $barangay = Barangay::find($id);
        $this->barangay_id = $barangay->id;
        $this->barangay_name = $barangay->barangay_name;
        $this->purok_name = $barangay->purok_name;

        $this->dispatch('openModal', [
            'id' => $barangay->id,
            'barangay_name' => $barangay->barangay_name,
            'purok_name' => $barangay->purok_name,
        ]);
    }

    public function updateBarangay()
    {
        // Find the barangay and update
        $barangay = Barangay::find($this->barangay_id);
        $barangay->barangay_name = $this->barangay_name;
        $barangay->purok_name = $this->purok_name;

        // Handle file upload if there's a new file
        if ($this->file) {
            $path = $this->file->storeAs('barangay_files', $this->file->getClientOriginalName());
            $barangay->file_path = $path; // Assuming you have a column for file_path
        }

        $barangay->save();

        session()->flash('success', 'Barangay updated successfully!');
        // Refresh the list and close the modal
        $this->refreshBarangays();
    }

    public function deleteBarangay($id)
    {
        // Find the barangay and update
        $barangay = Barangay::find($id);
        $barangay->delete();

        session()->flash('success', 'Barangay successfully deleted!');
        // Refresh the list and close the modal
        $this->refreshBarangays();
    }

    public function render()
    {
        return view('livewire.barangay-list', [
            'barangays' => $this->barangays,
        ]);
    }
}
