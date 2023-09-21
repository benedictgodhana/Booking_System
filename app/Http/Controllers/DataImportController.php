<?php

namespace App\Http\Controllers;



use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Imports\UsersDataImport;
use Illuminate\Support\Facades\Session; // Import the Session facade
class DataImportController extends Controller
{
    public function import(Request $request)
    {
        // Validate and handle the uploaded file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv',
        ]);

        // Import the data from the uploaded file
        Excel::import(new UsersDataImport, $request->file('file'));
        Session::flash('success', 'Data imported successfully.');

        // Optionally, you can add a success message
        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
