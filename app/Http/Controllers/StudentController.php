<?php

namespace App\Http\Controllers;

use App\Models\Student;

use Inertia\Inertia;


class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return Inertia::render('Student/index', ['students' => $students]);
    }


    public function updateStatus(string $id)
    {
        $student = Student::find($id);
        $student->status = $student->status === 1 ? 0 : 1; // Toggle status between 0 and 1
        $student->save();

        return back()->with('success', 'Status change successfully');
    }
    
}
