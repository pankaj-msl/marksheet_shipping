<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;
use App\Models\Student;
use App\Models\Document;
use App\Models\Shipment;
use Inertia\Inertia;


class PublicController extends Controller
{
    protected $apiService;
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }
    public function trackShipment()
    {
        $client = $this->apiService->fetchClientData('Active');
        
    }

    public function studentShipmentByRollNo($client_code = null, $student_rollNo = null){
        $client = $this->apiService->fetchClientData('Active');
        $admin = $this->apiService->fetchAdminData();
        if($student_rollNo)
        {
            $student = Student::with('documents.shipment')
                ->where('student_roll_no', $student_rollNo)
                ->where('client_code', Session::get('client_code'))->first();

            if($student){
                $shipments = Shipment::with('documents')->where('student_id', $student->id)->get();
                return inertia('Public/ShipmentTracking', ['student' => $student, 'shipments' => $shipments, 'admin' => $admin, 'client' => $client]);
            }
            return Inertia::render('Public/Error', ['message' => 'Student not found!']);
        }
        return inertia('Public/ShipmentTracking', ['admin' => $admin, 'client' => $client]);   
    }
}
