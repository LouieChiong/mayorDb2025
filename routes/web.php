<?php

use App\Http\Controllers\BarangayController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::get('barangay', [BarangayController::class, 'index'])
        ->name('barangay');

    Route::get('leaders', [BarangayController::class, 'leaders'])
        ->name('leaders');

    Route::get('voters', [BarangayController::class, 'voters'])
        ->name('voters');

    Route::get('voter-list/{leaderId}', [BarangayController::class, 'voterList'])
    ->name('voter-list');

    Route::get('/view-pdf/{file}', function ($file) {
            $path = 'barangay_files/' . $file;

            if (Storage::exists($path)) {
                return response()->file(asset('storage/images/mucipality-logo.jpg'), [
                    'Content-Disposition' => 'inline', // Forces the browser to display the PDF
                    'Content-Type' => 'application/pdf', // Ensures the browser knows it's a PDF
                ]);
            }

            abort(404, 'File not found');
        })->name('view.pdf');
});


require __DIR__.'/auth.php'; // Include auth routes */
