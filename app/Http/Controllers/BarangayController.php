<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Leader;
use App\Models\Voter;
use Exception;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    public function index()
    {
        return view('barangay');
    }

    public function leaders()
    {
        return view('leaders');
    }

    public function voters(Request $request)
    {
        try {
            $leaders = Leader::whereHas('barangay', function ($query) use ($request) {
                if ($request->filled('barangay')) {
                    $query->where('barangay_name', $request->barangay);
                }

                if ($request->filled('purok')) {
                    $query->where('purok_name', $request->purok);
                }

                if ($request->filled('precinct')) {
                    $query->where('precinct', $request->precinct);
                }
            })->get();

            return view('voters', ['leaders' => $leaders]);

        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function voterList(int $leaderId)
    {
        $voters = Voter::where('leader_id', $leaderId)->get();

        return view('voter-list', [
            'voters' => $voters,
            'leaderId' => $leaderId
        ]);
    }
}
