<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\Student;
use App\Models\Document;
use App\Models\Shipment;
use Inertia\Inertia;
use Carbon\Carbon;


class PublicController extends Controller
{

    public function visitShipmentTracking($client_code = null)
    {
        $client = $this->fetchClientData($client_code, 'Active');
        return inertia('Public/ShipmentTracking', ['client' => $client]);
    }

    public function studentShipmentByRollNo(Request $request){
        $student_rollNo = $request->student_roll_no;
        $student_name = $request->student_name;
        $client_code = $request->client_code;
        if($student_rollNo && $student_name)
        {
            $student = Student::with('documents.shipment')
                ->where('client_code', $client_code)
                ->where('student_roll_no', $student_rollNo)
                ->where('student_name', $student_name)
                    ->first();

            if($student){
                $shipments = Shipment::with('documents')->where('student_id', $student->id)->get();
                return response()->json(['student' => $student, 'shipments' => $shipments]);
            }
            return response()->json(['error' => 'Student not found!'], 404);
        }
        return response()->json(['error' => "Invalid Student Name or Roll Number"], 422);   
    }

    protected function fetchClientData($clientCode, $status)
    {
        $url = "https://h2raedgm17.execute-api.us-west-2.amazonaws.com/1/client/basic-info";
        $postData = ['client' => $clientCode, 'status' => $status ];
        
        $response = Http::withHeaders([
            'x-api-key' => config('app.x-api-key')
            ])->post($url, $postData);

        if ($response->successful() && isset($response->json()['data']) && !empty($response->json()['data'])) {
            return $response->json()['data'][0];
        } else {
            abort( response('Invalid response from the API', 401) );
            // abort( response()->json('Invalid response from the API', 401) );
        }

        return null;
    }
}
