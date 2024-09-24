<?php

namespace App\Exports;

use App\Models\Shipment;
use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class ShipmentsExport implements FromCollection, WithHeadings
{
    protected $studentId;

    public function __construct($studentId)
    {
        $this->studentId = $studentId;
    }

    public function collection()
    {
        return Document::whereHas('student', function ($query) {
                $query->where('id', $this->studentId)
                    ->where('client_code', session('client_code'));
        })
        ->with('student')
        ->get()
        ->map(function ($document) {
            return [
                'Student Name' => $document->student->student_name,
                'Student Roll No' => $document->student->student_roll_no,
                'Document Name' => $document->document_name,
                'Shipment Status' => $document->delivery_status,
                'Dispatched Date' => $document->document_dispatched_at ? Carbon::parse($document->document_dispatched_at)->format('Y-m-d') : 'N/A',
                'Delivered Date' => $document->document_delivered_at ? Carbon::parse($document->document_delivered_at)->format('Y-m-d') : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Student Name',
            'Student Roll No',
            'Document Name',
            'Shipment Status',
            'Dispatched Date',
            'Delivered Date',
        ];
    }
}