<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentMaster;

class DocumentMasterSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            [
                'document_name' => 'Degree',
                'status' => 'active',
                'document_type' => 'documents',
                'created_at' => '2024-08-31 11:23:17',
                'updated_at' => '2024-08-31 11:23:17',
            ],
            [
                'document_name' => 'Final Certificate',
                'status' => 'active',
                'document_type' => 'documents',
                'created_at' => '2024-08-31 11:24:35',
                'updated_at' => '2024-08-31 11:24:35',
            ],
            [
                'document_name' => 'Transcript',
                'status' => 'active',
                'document_type' => 'documents',
                'created_at' => '2024-08-31 11:25:08',
                'updated_at' => '2024-08-31 11:25:08',
            ],
            [
                'document_name' => 'Semester 1 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:25:29',
                'updated_at' => '2024-08-31 11:25:29',
            ],
            [
                'document_name' => 'Semester 2 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:25:58',
                'updated_at' => '2024-08-31 11:25:58',
            ],
            [
                'document_name' => 'Semester 3 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:26:21',
                'updated_at' => '2024-08-31 11:26:21',
            ],
            [
                'document_name' => 'Semester 4 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:26:36',
                'updated_at' => '2024-08-31 11:26:36',
            ],
            [
                'document_name' => 'Semester 5 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:26:57',
                'updated_at' => '2024-08-31 11:26:57',
            ],
            [
                'document_name' => 'Semester 6 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:27:54',
                'updated_at' => '2024-08-31 11:27:54',
            ],
            [
                'document_name' => 'Semester 7 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:28:11',
                'updated_at' => '2024-08-31 11:28:11',
            ],
            [
                'document_name' => 'Semester 8 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:28:26',
                'updated_at' => '2024-08-31 11:28:26',
            ],
            [
                'document_name' => 'Semester 9 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:28:39',
                'updated_at' => '2024-08-31 11:28:39',
            ],
            [
                'document_name' => 'Semester 10 Marksheet',
                'status' => 'active',
                'document_type' => 'semesters',
                'created_at' => '2024-08-31 11:28:55',
                'updated_at' => '2024-08-31 11:28:55',
            ],
        ];
        DocumentMaster::insert($documents);
    }
}
