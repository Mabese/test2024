<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution; // Make sure to import the Institutions model
use App\Models\Faculty;      // Make sure to import the Faculty model
use App\Models\Course;       // Make sure to import the Course model

class AdminController extends Controller
{
    // Add Institution 
    public function storeInstitution(Request $request)
    {
        // Validate input data.
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:institutions,email', // Specify column for unique constraint
            'address' => 'required|string',
        ]);

        // Create a new institution.
        Institution::create($request->only(['name', 'email', 'address'])); // Use only() for security

        return redirect()->back()->with('success', 'Institution added successfully.');
    }

    // Add Faculty 
    public function storeFaculty(Request $request)
    {
        // Validate input data.
        $request->validate([
            'name' => 'required|string|max:255',
            'institution_id' => 'required|exists:institutions,id',
        ]);

        // Create a new faculty.
        Faculty::create($request->only(['name', 'institution_id'])); // Use only() for security

        return redirect()->back()->with('success', 'Faculty added successfully.');
    }

    // Add Course 
    public function storeCourse(Request $request)
    {
        // Validate input data.
        $request->validate([
            'name' => 'required|string|max:255',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        // Create a new course.
        Course::create($request->only(['name', 'faculty_id'])); // Use only() for security

        return redirect()->back()->with('success', 'Course added successfully.');
    }

    // View Applications 
    public function viewApplications()
    {
        // Logic to view applications can be implemented here.
        // For now, we can return a view or redirect to a specific route
        return view('applications.index'); // Example return of a view
    }
}
