<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'teacher') {
            $teacherId = Auth::user()->id;
            $students = Student::with('user')->where('teacher_id', $teacherId)->get();
            if ($students->isEmpty()) {
                return view('teacher.dashboard', compact('students'))->with('message', 'No students found for this teacher.');
            }
            return view('teacher.dashboard', compact('students'));
        }
        return redirect('/')->with('error', 'Unauthorized Access!');
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Create teacher user
        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'teacher',
        ]);
        $teacher = new Teacher();
        $teacher->teacher_id = $user->id;
        $teacher->subject = $request->subject;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teachers', 'public');
            $teacher->photo = $photoPath;
        }

        $teacher->save();
        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6', // Password is optional for update
            'photo' => 'nullable|image',
        ]);

        try {

            $Teacher = Teacher::findOrFail($id);
            $user = User::findOrFail($Teacher->user_id);

            $user->name = $request->name;
            $user->email = $request->email;
            // Only update password if provided
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            $Teacher->subject = $request->subject;


            if ($request->hasFile('photo')) {
                if ($Teacher->photo) {
                    Storage::delete('public/' . $Teacher->photo);
                }
                $Teacher->photo = $request->file('photo')->store('Teachers', 'public');
            }
            $Teacher->save();
            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function dashboard()
    {
        return view('teacher.dashboard');
    }

    public function showStudents()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve the teacher details for the logged-in user
        $teacher = Teacher::where('user_id', $user->id)->first();

        // Check if the teacher exists
        if ($teacher) {
            // Fetch students assigned to this teacher
            $students = Student::where('class_teacher_id', $teacher->id)->get();

            return view('teacher.students', compact('students', 'teacher'));
        }

        return redirect('/')->with('error', 'No class assigned to you.');
    }
}
