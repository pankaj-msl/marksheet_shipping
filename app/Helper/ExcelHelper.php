<?php

function import(Request $request)
    {

            // Validate and store the uploaded file
            $request->validate(['csv' => 'required|file|mimes:csv,txt']);
            $file = $request->file('csv');
            $filePath = $file->store('csv', ['disk' => 'public']);
            $fileStream = fopen(storage_path('app/public/' . $filePath), 'r');

            // Initialize an empty array to hold CSV data
            $csvData = [];
            while (($row = fgetcsv($fileStream)) !== false) {
                $csvData[] = $row;
            }
            fclose($fileStream);

            // Assuming the CSV file has a header row
            $isHeader = true;
            foreach ($csvData as $dataRow) {
                if ($isHeader) {
                    $isHeader = false;
                    continue; // Skip the header row
                }

                // Prepare the data to be inserted or updated in the Student model
                $studentData = [
                    'id'                     => $dataRow[0],
                    'department_id'          => $dataRow[1],
                    'program_id'             => $dataRow[2],
                    'batch_id'               => $dataRow[3],
                    'client_code'            => $dataRow[4],
                    'student_roll_no'        => $dataRow[5],
                    'student_name'           => $dataRow[6],
                    'email'                  => $dataRow[7],
                    'student_city'           => $dataRow[8],
                    'student_address'        => $dataRow[9],
                    'student_pincode'        => $dataRow[10],
                    'exam_cycle'             => $dataRow[11],
                    'student_passing_year'   => $dataRow[12],
                    'student_exam_status'    => $dataRow[13],
                    'created_by'             => $dataRow[14],
                    'created_at'             => $dataRow[15] ?? now(), // Use current timestamp if not provided
                    'updated_at'             => $dataRow[16] ?? now(), // Use current timestamp if not provided
                ];

                // Insert or update the record in the Student model
                Student::updateOrCreate(
                    ['id' => $studentData['id']],  // Use 'id' as the unique key for updates
                    $studentData                  // The data to insert or update
                );
    }

    // Delete the uploaded file after processing
    Storage::disk('public')->delete($filePath);
    return response()->json(['students' => $csvData]);

    }
