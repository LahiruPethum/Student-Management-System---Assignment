<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;


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

    public function create()
    {
        return Inertia::render('Student/create');
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('student/create')
                ->withErrors($validator)
                ->withInput();
        }

        $input = $validator->validated();

        $file = $request->file('image');

        $filename = Str::random(10) . '.' . $file->extension();

        $file->move(public_path('users'), $filename);

        $input['image'] = $filename;


        Student::create($input);

        return redirect('students')->with('success', 'Student Added Successfully');
    }
}
