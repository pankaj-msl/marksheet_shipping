<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShipmentRequest;
use App\Models\Student;
use App\Models\Document;
use App\Models\Shipment;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;
use App\Exports\ShipmentsExport;
use App\Exports\ShipmentsReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Inertia\Inertia;

class ShipmentController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index(Request $request)
    {
        $client = $this->apiService->fetchClientData('Active');
        $admin = $this->apiService->fetchAdminData();
        
        return inertia('Shipments', compact('client', 'admin'));
    }

    public function fetchShipments(Request $request)
    {
        $search = $request->input('query');
        $students = Student::with('documents.shipment')
            ->whereHas('documents')
            ->where('client_code', session('client_code'))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('student_roll_no', 'like', "%{$search}%")
                        ->orWhere('student_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(3);

            return response()->json(['students' => $students]);
    }
    public function visitShipment($student_id){
        $client = $this->apiService->fetchClientData('Active');
        $admin = $this->apiService->fetchAdminData();
        $student = Student::with('documents.shipment')->where('id', $student_id)->first();
        $shipments = Shipment::with('documents')->where('student_id', $student_id)->get();
        return inertia('Shipment', ['student' => $student, 'shipments' => $shipments, 'admin' => $admin, 'client' => $client]);
    }

    public function createShipment(ShipmentRequest $request){
        $student_id = $request->input('student_id');
        $shipment_id = $request->input('shipment_id');
        $document_ids = $request->input('document_ids');
        $tracking_id = $request->input('tracking_id');
        $shipping_agent = $request->input('shipping_agent');
        $shipping_address = $request->input('shipping_address');
        $dispatched_at = $request->input('dispatched_at');
        $amount = $request->input('amount');
        $delivery_status = $request->input('delivery_status');
        $delivered_at = $request->input('delivered_at');
        if(empty($shipment_id)){
            $shipment = Shipment::create([
                'student_id' => $student_id,
                'tracking_id' => $tracking_id,
               'shipping_agent' => $shipping_agent,
               'shipping_address' => $shipping_address,
                'dispatched_at' => $dispatched_at,
                'amount' => $amount,
                'delivery_status' => $delivery_status,
                'delivered_at' => $delivered_at,
            ]);
            $shipment_id = $shipment->id;
            foreach($document_ids as $document_id){
                Document::where('id', $document_id)->update([
                    'shipment_id' => $shipment_id,
                    'delivery_status' => $delivery_status, 
                    'document_dispatched_at' => $dispatched_at ?? null ]);
            }
            $message = "Shipment has been successfully created.";
        }
        else{
            Shipment::where('id', $shipment_id)->update([
                'tracking_id' => $tracking_id,
               'shipping_agent' => $shipping_agent,
               'shipping_address' => $shipping_address,
                'dispatched_at' => $dispatched_at,
                'amount' => $amount,
                'delivery_status' => $delivery_status,
                'delivered_at' => $delivered_at,
            ]);
            Document::whereIn('id', $document_ids)->update([
                'delivery_status' => $delivery_status, 
                'document_dispatched_at' => $dispatched_at,
                'document_delivered_at' => $dispatched_at ?? null,
                'updated_at' => now(),
            ]);
            $message = "Shipment has been successfully updated.";
        }
        $student = Student::with('documents.shipment')->where('id', $student_id)->first();
        $shipments = Shipment::with('documents')->where('student_id', $student_id)->get();
        return response()->json(['student' => $student, 'shipments' => $shipments]);
    }

    public function generateReport($studentId)
    {
        return Excel::download(new ShipmentsExport($studentId), 'shipments_student_'.$studentId.'.xlsx');
    }

    public function downloadShipments()
    {
        return Excel::download(new ShipmentsReportExport(), 'shipment_report.xlsx');
    }
}