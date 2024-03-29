<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

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

    public function show(string $id)
    {
        $student = Student::findOrFail($id);
        $dateOfBirth = Carbon::parse($student->dob);
        $age = $dateOfBirth->diffInYears(Carbon::now());
        return Inertia::render('Student/show', [
            'student' => $student,
            'age' => $age
        ]);
    }

    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        return Inertia::render('Student/edit', [
            'student' => $student
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $student = Student::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $input = $validator->validated();

        if ($request->hasFile('image')) {
            if ($student->image) {
                unlink(public_path('users/' . $student->image));
            }
            $file = $request->file('image');
            $filename = Str::random(10) . '.' . $file->extension();
            $file->move(public_path('users'), $filename);
            $input['image'] = $filename;
        }

        $student->update([
            'name' => $input['name'], // Always include the name field
            'dob' => $input['dob'],
            'image' => $input['image'] ?? $student->image, // Use existing image if no new image is uploaded
        ]);

        return redirect('students')->with('success', 'Student Updated Successfully');
        // dd($request->all());

    }

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
    
        if ($student->image) {
            $imagePath = public_path('users/' . $student->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        $student->delete();
    
        return Inertia::location(route('students'));
    }
}
