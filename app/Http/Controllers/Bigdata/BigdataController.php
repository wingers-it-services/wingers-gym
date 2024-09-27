<?php

namespace App\Http\Controllers\Bigdata;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class BigdataController extends Controller
{
    public function uploadTableView()
    {
        return view('table_upload');
    }

    public function uploadTableData(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'table_name' => 'required|string',
                'column_names' => 'required|array|min:1',
                'file' => 'required|file|mimes:csv,txt',
            ]);
    
            Log::info('Request data: ' . json_encode($request->all()));
            // Get table name and column details from request
            $table_name = $request->input('table_name');
            $input_columns = $request->input('column_names');
    
            // Get the actual columns from the database table
            $table_columns = DB::connection('big_data')->getSchemaBuilder()->getColumnListing($table_name);
    
            // Adjust the input columns to match the database columns
            $column_names = array_intersect($table_columns, $input_columns); // Filter to match the DB table fields
            $extra_columns = array_diff($table_columns, $column_names); // Missing columns to be filled with NULL
    
            if (count($column_names) == 0) {
                return response()->json(['error' => 'No matching columns found in the database table.'], 400);
            }
    
            // Check if file is uploaded
            if ($request->hasFile('file')) {
                $file = $request->file('file')->getRealPath();
    
                if (($handle = fopen($file, 'r')) !== false) {
                    // Skip the header if there is one
                    fgetcsv($handle);
    
                    // Start a database transaction
                    DB::connection('big_data')->beginTransaction();
    
                    try {
                        $batchData = []; // Store all rows in batchData
    
                        // Read CSV line by line
                        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                            if (is_array($data)) {
                                // Limit data to match the column names size
                                $data = array_slice($data, 0, count($column_names));
    
                                // Fill extra columns with NULL
                                $data = array_merge($data, array_fill(0, count($extra_columns), null));
    
                                $batchData[] = $data;
                            }
                        }
    
                        fclose($handle);
    
                        // Insert batch data
                        $this->insertBatch($table_name, array_merge($column_names, $extra_columns), $batchData);
    
                        // Commit the transaction
                        DB::connection('big_data')->commit();
    
                        return response()->json(['message' => 'Data imported successfully!']);
                    } catch (Exception $e) {
                        // Rollback the transaction if any error occurs
                        DB::connection('big_data')->rollBack();
                        Log::error('[BigdataController][uploadTableData] error : '.$e->getMessage());
                        return response()->json(['error' => 'Data import failed: ' . $e->getMessage()], 500);
                    }
                } else {
                    return response()->json(['error' => 'Error opening the file.'], 500);
                }
            } else {
                return response()->json(['error' => 'No file uploaded.'], 400);
            }
        } catch (Exception $e) {
            // Handle any validation or general exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    
    private function insertBatch($table_name, $column_names, $batchData)
    {
        // Prepare columns by quoting each column name
        $columns = implode(", ", array_map(function ($col) {
            return "`$col`";
        }, $column_names));
    
        // Prepare placeholders for the SQL query (as many as the number of columns)
        $placeholder_count = count($column_names);
        $placeholders = implode(", ", array_fill(0, $placeholder_count, '?'));
    
        // Initialize the SQL query for bulk insertion
        $sql = "INSERT INTO `$table_name` ($columns) VALUES ($placeholders)";
    
        // Iterate over batch data and ensure data length matches column count
        foreach ($batchData as $rowData) {
            $rowData = array_slice($rowData, 0, $placeholder_count); // Ensure no extra values
            $rowData = array_pad($rowData, $placeholder_count, null); // Fill missing values with NULL
    
            DB::connection('big_data')->insert($sql, $rowData);
        }
    }
    
}
