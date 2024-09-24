<?php

namespace App\Http\Controllers;

use App\Imports\MarksheetImport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\Document;
use App\Models\DocumentMaster;
use App\Services\ApiService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class MarksheetController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function register()
    {
        return redirect()->route('marksheet.index');
    }

    public function index()
    {
        $client = $this->apiService->fetchClientData('Active');
        $admin = $this->apiService->fetchAdminData();

        if($client && $admin){
            return inertia('Marksheet', compact('client', 'admin'));
        }
        return response()->json(['error' => 'Failed to retrieve data'], 500);
    }

    public function fetchAPIs(){
        $batches = $this->apiService->fetchBatchData();
        $departments = $this->apiService->fetchDepartmentData();
        $examCycles = $this->apiService->fetchExamCycleData();
        return response()->json([$batches, $departments, $examCycles]);
    }


    public function fetchPrograms(Request $request)
    {
        $departmentId = $request->departmentId;
        $programs = $this->apiService->fetchProgramData($departmentId);
        return $programs;
    }

    public function fetchDocuments(Request $request)
    {
        $docType = $request->input('doc_type');
        $documents = DocumentMaster::select('document_name')->where('document_type', $docType)->get();
        return response()->json($documents);
    }

    public function uploadEligibleStudent(Request $request) {
        $departmentId = $request->input('department_id');
        $programId = $request->input('program_id');
        $batchId = $request->input('batch_id');
        $examCycle = $request->input('examCycle');
        $client_code = Session::get('client_code');
        $created_by = Session::get('username');
        if ($request->hasFile('csv')) {
            $file = $request->file('csv');
            try {
                Excel::import(new MarksheetImport($departmentId, $programId, $batchId, $examCycle, $client_code, $created_by), $file);
                return $this->searchAndFilter($request);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error importing file: ' . $e->getMessage()], 500);
            }
        }
    }

    public function searchAndFilter(Request $request)
    {
        $marksheetQuery = Student::query()->where('client_code', session('client_code'));
        $students = $this->applySearch(
            $marksheetQuery, 
            $request->input('query'), 
            $request->input('pass_status') ?? null,
            $request->input('generated_status') ?? null
        );
        $studentsIds = $students->pluck('id');

        $students = Student::with('documents')->whereIn('id', $studentsIds)->paginate(10);

        return response()->json(['students' => $students]);
    }


    protected function applySearch(Builder $query, $search, $passStatusFilter, $generatedStatusFilter)
    {
        return $query->when($search, function ($query) use ($search){
            $query->where(function ($query) use ($search){
                $query->where('student_name', 'like', '%'. $search. '%')
                    ->orWhere('student_roll_no', 'like', '%'. $search. '%')
                    ->orWhere('email', 'like', '%'. $search. '%');
            });
        })
        ->when($passStatusFilter, function ($query) use ($passStatusFilter){
            $query->where('student_exam_status', $passStatusFilter);
        })
        ->when($generatedStatusFilter == 'generated', function ($query){
            $query->whereHas('documents');
        })
        ->when($generatedStatusFilter == 'not_generated', function ($query){
            $query->whereDoesntHave('documents');
        });
    }

    public function updatePassStatus(Request $request)
    {
        $studentsIds = $request->input('students'); //Array of students IDs
        $passStatus = $request->input('pass_status');

        if(!is_array($studentsIds) || empty($studentsIds)){
            return response()->json(['error' => 'No students selected'], 400);
        }

        Student::whereIn('id', $studentsIds)->update(['student_exam_status' => $passStatus]);
        return response()->json(['message' => 'Pass status updated successfully']);
    }

    public function updateDocuments(Request $request){
        $studentsIds = $request->input('students'); //Array of students IDs
        $documentType = $request->input('doc_type');
        $documents = $request->input('docs'); //Array of documents
        if(!is_array($studentsIds) || empty($studentsIds) ||!is_array($documents) || empty($documents)){
            return response()->json(['error' => 'No students or documents selected'], 400);
        }

        // Iterate over each student and document name to update or create the corresponding records
        collect($studentsIds)->each(function ($studentId) use ($documents, $documentType) {
            collect($documents)->each(function ($document) use ($studentId, $documentType) {
                Document::updateOrCreate(
                    [
                        // Conditions to identify the document related to the student
                        'student_id' => $studentId,
                        'document_type' => $documentType,
                        'document_name' => $document,
                    ],
                    [
                        // Fields to set when creating or updating the document
                        'student_id' => $studentId,
                        'document_type' => $documentType,
                        'document_name' => $document,
                        'is_document_generated' => 'yes',
                        'document_generated_at' => now(),
                    ]
                );
            });
        });

        return response()->json(['message' => 'Documents updated or created successfully'], 200);
    }
}
