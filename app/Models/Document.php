<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable =
    [
        'id',
        'student_id',
        'shipment_id',
        'document_type',
        'document_path',
        'document_name',
        'is_document_generated',
        'document_generated_at',
        'document_dispatched_at',
        'document_delivered_at',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function shipment(){
        return $this->belongsTo(Shipment::class);
    }
}
