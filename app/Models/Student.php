<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    protected $fillable = [
        'id',
        'department_id',
        'program_id',
        'batch_id',
        'client_code',
        'student_roll_no',
        'student_name',
        'email',
        'student_city',
        'student_address',
        'student_pincode',
        'exam_cycle',
        'student_passing_year',
        'student_exam_status',
        'created_by',
        'created_at',
        'updated_at'
    ];

    public function documents(){
        return $this->hasMany(Document::class);
    }

    public function shipments(){
        return $this->hasMany(Shipment::class);
    }

    protected function casts(): array
    {
        return [
            'student_passing_year' => 'date',
        ];
    }
}
