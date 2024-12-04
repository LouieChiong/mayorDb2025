<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Barangay;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangayForm extends Component
{
    use WithFileUploads;

    public $barangay_name;
    public $purok_name;
    public $precinct;
    public $file;

    protected $rules = [
        'barangay_name' => 'required|string|max:255',
        'purok_name' => 'required|string|max:255', 
        'file' => 'nullable|file|mimes:pdf',
    ];

    public function submit()
    {
        $validatedData = $this->validate();

        // Handle file upload if provided
        if ($this->file) {
            // Extract the original file name
            $originalName = $this->file->getClientOriginalName();

            // Ensure unique file name to avoid overwrites
            $fileName = time() . '_' . $originalName;

            // Store the file using the original name
            $filePath = $this->file->storeAs('barangay_files', $fileName, 'public');

            $validatedData['file_path'] = $filePath;
        }

        // Save the data to the database
        Barangay::create([
            'barangay_name' => $this->barangay_name,
            'purok_name' => $this->purok_name, 
            'file_path' => $validatedData['file_path'] ?? null,
        ]);

        // Reset the form fields
        $this->reset(['barangay_name', 'purok_name', 'precinct', 'file']);

        return redirect()->to(request()->header('Referer'))->with('success', 'Barangay registered successfully!');
    }

    public function downloadExcel()
    {
        $data = [
            'barangays' => Barangay::all()->sortBy(['barangay_name'])
        ];

        $pdf = Pdf::loadView('download-barangay-list', $data)->setPaper('a4', 'landscape');

        // Download PDF file
        return response()->streamDownload(
            fn() => print($pdf->stream()),
            'barangay-list.pdf'
        );
    }

    public function render()
    {
        return view('livewire.barangay-form');
    }
}
