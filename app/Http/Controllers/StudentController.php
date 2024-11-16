<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::with(['user', 'teacher'])->get();
        return view('students.index', compact('students'));
    }


    public function create()
    {
        $teachers = Teacher::with('user')->get(); // Fetch teachers with their user data
        return view('students.create', compact('teachers'));
    }


    public function store(Request $request)
    {
        // Step 1: Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'teacher_id' => 'required|exists:teachers,id',
            'admission_date' => 'required|date',
            'yearly_fees' => 'required|numeric',
            'photo' => 'nullable|image',
        ]);

        try {
          
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // Create the student record
            $student = new Student();
            $student->user_id = $user->id;
            $student->teacher_id = $request->teacher_id;
            $student->admission_date = $request->admission_date;
            $student->yearly_fees = $request->yearly_fees;

            //  Handle photo upload
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('students', 'public');
                $student->photo = $photoPath;
            }

            $student->save();
            return redirect()->route('students.index')->with('success', 'Student created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $teachers = Teacher::all(); 
        return view('students.edit', compact('student', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6', 
            'teacher_id' => 'required|exists:teachers,id',
            'admission_date' => 'required|date',
            'yearly_fees' => 'required|numeric',
            'photo' => 'nullable|image',
        ]);

        try {

            $student = Student::findOrFail($id);
            $user = User::findOrFail($student->user_id);

            $user->name = $request->name;
            $user->email = $request->email;
            // Only update password if provided
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
            $student->teacher_id = $request->teacher_id;
            $student->admission_date = $request->admission_date;
            $student->yearly_fees = $request->yearly_fees;


            if ($request->hasFile('photo')) {
                if ($student->photo) {
                    Storage::delete('public/' . $student->photo);
                }
                $student->photo = $request->file('photo')->store('students', 'public');
            }
            $student->save();
            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Retrieve the student by ID
        $student = Student::with(['user', 'user.teacher'])->findOrFail($id);
        return view('students.show', compact('student'));
    }



    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }





    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $student = Student::with(['user', 'user.teacher'])->where('user_id', $user->id)->first();

        if (!$student) {
            return redirect('/')->with('error', 'Student record not found!');
        }
        return view('students.dashboard', compact('student'));
    }
}
