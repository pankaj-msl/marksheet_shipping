<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;
use App\Models\Student;
use App\Models\Document;
use App\Models\Shipment;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        $client = $this->apiService->fetchClientData('Active');
        $admin = $this->apiService->fetchAdminData();
        

        return Inertia::render('Dashboard', [
            'client' => $client,
            'admin' => $admin,
            
        ]);
    }

    public function fetchSummary()
    {
        $generated = Document::whereHas('student', function($query) {
            $query->where('client_code', session('client_code'));
        })->count();
        $students = Student::where('client_code', session('client_code'))->count();
        return response()->json(['generatedDocs' => $generated, 'students' => $students]);
    }

    public function summaryStats()
    {
        $pendings = Document::whereHas('student', function($query) {
            $query->where('client_code', session('client_code'));
        })->where('shipment_id', null)->count();
        
        $shipped = Document::whereHas('student', function($query){
            $query->where('client_code', session('client_code'));
        })
        ->whereHas('shipment', function ($query) {
            $query->where('delivery_status', 'shipped');
        })->count();

        $delivered = Document::whereHas('student', function($query){
            $query->where('client_code', session('client_code'));
        })
        ->whereHas('shipment', function ($query) {
            $query->where('delivery_status', 'delivered');
        })->count();

        $passed = Student::where('client_code', session('client_code'))
        ->where('student_exam_status', 'passed')->count();

        $failed = Student::where('client_code', session('client_code'))
        ->where('student_exam_status', 'failed')->count();

        return response()->json([
            'pendings' => $pendings,
           'shipped' => $shipped,
            'delivered' => $delivered,
            'passed' => $passed,
            'failed' => $failed,
        ]);


    }

    public function populateExamCycle()
    {
        $examCycles = Student::where('client_code', session('client_code'))->distinct()->pluck('exam_cycle');
        return response()->json(['exam_cycles' => $examCycles]);
    }

    public function examCycleStats(Request $request)
    {
        $exam_cycle = $request->exam_cycle;
        $pendings = Document::where('shipment_id', null)->whereHas('student', function ($query) use ($exam_cycle) {
            $query->where('exam_cycle', $exam_cycle)
                ->where('client_code', session('client_code'));
        })->count();

        $delivered = Document::whereHas('shipment', function ($query) {
            $query->where('delivery_status', 'delivered');
        })->wherehas('student', function ($query) use ($exam_cycle) {
            $query->where('exam_cycle', $exam_cycle)
                ->where('client_code', session('client_code'));
        })->count();

        $shipped = Document::whereHas('shipment', function ($query) {
            $query->where('delivery_status', 'shipped');
        })->wherehas('student', function ($query) use ($exam_cycle) {
            $query->where('exam_cycle', $exam_cycle)
                ->where('client_code', session('client_code'));
        })->count(); 
        
        $passed = Student::where('client_code', session('client_code'))
                            ->where('exam_cycle', $exam_cycle)
                            ->where('student_exam_status', 'passed')->count();
        
        $failed = Student::where('client_code', session('client_code'))
                            ->where('exam_cycle', $exam_cycle)
                            ->where('student_exam_status', 'failed')->count();


        return response()->json([
            'pendings' => $pendings,
           'shipped' => $shipped,
            'delivered' => $delivered,
            'passed' => $passed,
            'failed' => $failed,
        ]);
    }


    public function examCycleTimeline()
{
    // Fetch all unique exam cycles from the database
    $examCycles = Student::where('client_code', session('client_code'))->distinct()->pluck('exam_cycle');

    // Prepare an array to store the data for each status
    $timelineData = [
        'categories' => $examCycles,
        'series' => [
            ['name' => 'Pendings', 'data' => []],
            ['name' => 'Shipped', 'data' => []],
            ['name' => 'Delivered', 'data' => []],
            // ['name' => 'Passed', 'data' => []],
            // ['name' => 'Failed', 'data' => []],
        ],
    ];

    // Iterate over each exam cycle and fetch the counts for each status
    foreach ($examCycles as $exam_cycle) {
        // Fetch counts for each status within the current exam cycle
        $pendings = Document::whereHas('student', function($query){
            $query->where('client_code', session('client_code'));
        })
        ->where('shipment_id', null)
            ->whereHas('student', fn($query) => $query->where('exam_cycle', $exam_cycle))
            ->count();

        $shipped = Document::whereHas('student', function($query){
            $query->where('client_code', session('client_code'));
        })
        ->whereHas('shipment', fn($query) => $query->where('delivery_status', 'shipped'))
            ->whereHas('student', fn($query) => $query->where('exam_cycle', $exam_cycle))
            ->count();

        $delivered = Document::whereHas('student', function($query){
            $query->where('client_code', session('client_code'));
        })
        ->whereHas('shipment', fn($query) => $query->where('delivery_status', 'delivered'))
            ->whereHas('student', fn($query) => $query->where('exam_cycle', $exam_cycle))
            ->count();

        // $passed = Student::where('exam_cycle', $exam_cycle)
        //     ->where('student_exam_status', 'passed')
        //     ->count();

        // $failed = Student::where('exam_cycle', $exam_cycle)
        //     ->where('student_exam_status', 'failed')
        //     ->count();

        // Append the data to the corresponding series
        $timelineData['series'][0]['data'][] = $pendings;
        $timelineData['series'][1]['data'][] = $shipped;
        $timelineData['series'][2]['data'][] = $delivered;
        // $timelineData['series'][3]['data'][] = $passed;
        // $timelineData['series'][4]['data'][] = $failed;
    }

    return response()->json($timelineData);
}


}
