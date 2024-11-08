<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Institution;
use App\Models\Course;
use app\Models\Application;
use Illuminate\Http\Request;


class InstituteController extends Controller
{
      // Show form for adding a new institution
      public function create()
      {
          return view('admin.add_institution');
      }
  
      // Store a new institution
      public function store(Request $request)
      {
          $request->validate([
              'name' => 'required|string|max:255',
              'email' => 'required|email|unique:institutions',
              'address' => 'required|string',
          ]);
  
          Institution::create($request->all());
  
          return redirect()->back()->with('success', 'Institution added successfully.');
      }
  
      // Show form for adding a faculty to an institution
      public function createFaculty()
      {
          $institutions = Institution::all();
          return view('admin.add_faculty', compact('institutions'));
      }
  
      // Store a new faculty under an institution
      public function storeFaculty(Request $request)
      {
          $request->validate([
              'name' => 'required|string|max:255',
              'institution_id' => 'required|exists:institutions,id',
          ]);
  
          Faculty::create($request->all());
  
          return redirect()->back()->with('success', 'Faculty added successfully.');
      }
  
      // Show form for adding a course to a faculty
      public function createCourse()
      {
          $faculties = Faculty::all();
          return view('admin.add_course', compact('faculties'));
      }
  
      // Store a new course under a faculty
      public function storeCourse(Request $request)
      {
          $request->validate([
              'name' => 'required|string|max:255',
              'faculty_id' => 'required|exists:faculties,id',
          ]);
  
          Course::create($request->all());
  
          return redirect()->back()->with('success', 'Course added successfully.');
      }
  
     // View applications submitted to this institution (for admin use)
     public function viewApplications($institutionId)
     {
         $applications = Application::where('institution_id', $institutionId)->get();
         return view('admin.view_applications', compact('applications'));
     }
}
