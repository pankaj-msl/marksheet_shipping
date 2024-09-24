<?php
namespace App\Services;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Http;


class ApiService
{
    protected $apiKey, $clientCode, $response_header;

    public function __construct()
    {
        if(session()->has('client_code') && session()->has('username')){
            $this->apiKey = config('app.x-api-key');
            $this->clientCode = Session::get('client_code');
            $this->response_header = Http::withHeaders(['x-api-key' => $this->apiKey]);
        }
        else{
            abort(403, "You're not authorized to make this request, back off!");
        }
    }

    public function fetchClientData($status)
    {
        $url = "https://h2raedgm17.execute-api.us-west-2.amazonaws.com/1/client/basic-info";
        $postData = ['client' => $this->clientCode, 'status' => $status ];

        $response = $this->response_header->post($url, $postData);

        if ($response->successful() && isset($response->json()['data']) && !empty($response->json()['data'])) {
            return $response->json()['data'][0];
        } else {
            return response()->json(['error' => 'Invalid response from the API'], 400);
        }

        return null;
    }

    public function fetchAdminData()
    {
        $url = "https://h2raedgm17.execute-api.us-west-2.amazonaws.com/1/admin/admin-user-info";
        $postData = ['client' => $this->clientCode, 'username' => Session::get('username')];

        $response = $this->response_header->post($url, $postData);

        if ($response->successful() && isset($response->json()['data']) && !empty($response->json()['data'])) {
            return $response->json()['data'][0];
        } else {
            return response()->json(['error' => 'Invalid response from the API'], 400);
        }

        return null;
    }

    public function fetchBatchData($status = null)
    {
        $url = "https://h2raedgm17.execute-api.us-west-2.amazonaws.com/1/admin/batch/fetch";
        $postData = ['client_code' => $this->clientCode,'status' => $status];

        $response = $this->response_header->post($url, $postData);

        if($response->successful()){
            return $response->json()['data'];
        }

        return null;
    }

    public function fetchDepartmentData()
    {
        $url = "https://h2raedgm17.execute-api.us-west-2.amazonaws.com/1/admin/department/fetch";
        $postData = ['client' => $this->clientCode];

        $response = $this->response_header->post($url, $postData);

        if($response->successful()){
            return $response->json()['data'];
        }

        return null;
    }

    public function fetchProgramData($departmentId)
    {
        $url = "https://h2raedgm17.execute-api.us-west-2.amazonaws.com/1/admin/program/fetch";
        $postData = ['client' => $this->clientCode, 'department_id' => $departmentId];
        $response = $this->response_header->post($url, $postData);

        if($response->successful()){
            return $response->json()['data'];
        }

        return null;
    }

    public function fetchExamCycleData()
    {
        $url = "https://h2raedgm17.execute-api.us-west-2.amazonaws.com/1/admin/exam/exam-cycle-list";
        $postData = ['client' => $this->clientCode];
        $response = $this->response_header->post($url, $postData);

        if($response->successful()){
            return $response->json()['data'];
        }
        return null;
    }
}
