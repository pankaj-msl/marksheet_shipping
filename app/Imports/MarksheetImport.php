<?php
namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Student;
class MarksheetImport implements ToModel, WithHeadingRow
{
    protected $departmentId;
    protected $batchId;
    protected $programId;
    protected $examCycle;
    protected $client_code;
    protected $created_by;
    public function __construct($departmentId, $programId, $batchId, $examCycle, $client_code, $created_by)
    {
        $this->departmentId = $departmentId;
        $this->programId = $programId;
        $this->batchId = $batchId;
        $this->examCycle = $examCycle;
        $this->client_code = $client_code;
        $this->created_by = $created_by;
    }
    public function model(array $row) {
        // dd();
        return new Student([
            'student_name'      => $row['student_name'],
            'email' => $row['email'],
            'student_city'      => $row['student_city'],
            'student_address'   => $row['student_address'],
            'student_pincode'   => $row['student_pincode'],
            'student_passing_year' => $row['student_passing_year'],
            'student_roll_no' => $row['student_roll_no'],
            'department_id' => $this->departmentId,
            'batch_id' => $this->batchId,
            'program_id' => $this->programId,
            'exam_cycle' => $this->examCycle,
            'client_code' => $this->client_code,
            'created_by' => $this->created_by,
        ]);
    }
}
