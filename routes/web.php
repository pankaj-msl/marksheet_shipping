<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MarksheetController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// });
//============================ Marksheet Controller =============================
Route::any('marksheet/register/{data?}', [MarksheetController::class, 'register'])->name('marksheet.register')->middleware('ClientCode'); //to redirect to portal, only authenticated token
Route::get('marksheet/index', [MarksheetController::class, 'index'])->name('marksheet.index');
Route::get('marksheet/programs/{departmentId}', [MarksheetController::class, 'fetchPrograms'])->name('marksheet.programs');
Route::post('marksheet/upload', [MarksheetController::class, 'uploadEligibleStudent'])->name('marksheet.import');
Route::get('/marksheet/upload', [MarksheetController::class, 'getPaginatedStudents']);
Route::get('/marksheet/search', [MarksheetController::class, 'searchAndFilter']);
Route::post('/marksheet/update-pass-status', [MarksheetController::class, 'updatePassStatus']);
Route::post('/marksheet/update-documents', [MarksheetController::class, 'updateDocuments']);
Route::get('/marksheet/documents', [MarksheetController::class, 'fetchDocuments']);
Route::get('/fetch/Apis', [MarksheetController::class, 'fetchAPIs']);

//============================ Shipment Controller =============================
Route::get('/shipments', [ShipmentController::class, 'index']);
Route::get('/shipments/view', [ShipmentController::class, 'fetchShipments']);
Route::get('/shipment/student/{student_id}', [ShipmentController::class, 'visitShipment']);
Route::post('/shipments/create', [ShipmentController::class, 'createShipment']);
Route::get('/shipments/generate-report/{studentId}', [ShipmentController::class, 'generateReport']);
Route::get('/shipments/download', [ShipmentController::class, 'downloadShipments']);


//============================ Dashboard Controller =============================
Route::get('/marksheet/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/summary', [DashboardController::class, 'fetchSummary']);
Route::get('/dashboard/summary/stats', [DashboardController::class, 'summaryStats']);
Route::get('/dashboard/exam_cycle/stats', [DashboardController::class, 'examCycleStats']);
Route::get('/fetch/students', [DashboardController::class, 'fetchStudents']);
Route::get('/dashboard/exam_cycle/timeline', [DashboardController::class, 'examCycleTimeline']);
Route::get('/dashboard/populateExamCycle', [DashboardController::class, 'populateExamCycle']);
// ============================== Public Controller =============================
// Route::get('/shipment/track/{client_code}/{student_rollNo?}', [PublicController::class, 'studentShipmentByRollNo'])->middleware('PublicToken');
Route::get('/shipment/track/{client_code}', [PublicController::class, 'visitShipmentTracking']);
Route::post('/shipment/fetch', [PublicController::class, 'studentShipmentByRollNo']);


require __DIR__.'/auth.php';
