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
            $query = Leader::whereHas('barangay', function ($query) use ($request) {
                if ($request->filled('barangay')) {
                    $query->where('barangay_name', $request->barangay);
                }

                if ($request->filled('purok')) {
                    $query->where('purok_name', $request->purok);
                }
            });


            if ($request->filled('first_name')) {
                $query->where('first_name', 'like', '%' . $request->first_name . '%');
            }

            if ($request->filled('last_name')) {
                $query->where('last_name', 'like', '%' . $request->last_name . '%');
            }

            if ($request->filled('middle_name')) {
                $query->where('middle_name', 'like', '%' . $request->middle_name . '%');
            }

            $leaders =  $query->get();

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
