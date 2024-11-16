<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = auth()->user();
        
        // Fetch all teachers if the user is a student
        $teachers = $user->role === 'student' ? Teacher::all() : [];
    
        return view('profile.edit', compact('user', 'teachers'));
    }

    
    public function editProfile($id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        
        if ($user->role === 'teacher') {
            // Fetch teacher data
            $teacher = Teacher::where('user_id', $user->id)->first();
            return view('profile.edit', compact('user', 'teacher'));
        } elseif ($user->role === 'student') {
            // Fetch student data and all teachers for dropdown
            $student = Student::where('user_id', $user->id)->first(); // Ensure the student exists
            $teachers = Teacher::all(); // Get all teachers
            return view('profile.edit', compact('user', 'student', 'teachers')); // Pass student and teachers to the view
        }
    
        return redirect()->back()->with('error', 'Invalid user role');
    }
    

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }


    // public function update(Request $request)
    // {
    //     // Validate the input
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //     ]);

    //     // Update the user's profile
    //     $user = Auth::user();
    //     $user->name = $request->name;
    //     $user->email = $request->email;

    //     if ($user->save()) {
    //         return redirect()->back()->with('success', 'Profile updated successfully!');
    //     }

    //     return redirect()->back()->with('error', 'Failed to update profile.');
    // }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|min:6', // Password is optional for update
            'photo' => 'nullable|image',
        ]);
    
        try {
            // Find the user
            $user = User::findOrFail($id);
    
            // Update the user details
            $user->name = $request->name;
            $user->email = $request->email;
            
            // Only update password if provided
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            
            $user->save();
    
            // Handle Teacher-specific fields
            if ($user->role === 'teacher') {
                $teacher = Teacher::findOrFail($user->teacher->id);
                $teacher->subject = $request->subject;
    
                if ($request->hasFile('photo')) {
                    // Delete old photo if it exists
                    if ($teacher->photo) {
                        Storage::delete('public/' . $teacher->photo);
                    }
                    $teacher->photo = $request->file('photo')->store('Teachers', 'public');
                }
    
                $teacher->save();
                return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
            }
    
            // Handle Student-specific fields
            elseif ($user->role === 'student') {
                $student = Student::findOrFail($user->student->id);
                $student->teacher_id = $request->teacher_id;
                $student->admission_date = $request->admission_date;
                $student->yearly_fees = $request->yearly_fees;
    
                if ($request->hasFile('photo')) {
                    // Delete old photo if it exists
                    if ($student->photo) {
                        Storage::delete('public/' . $student->photo);
                    }
                    $student->photo = $request->file('photo')->store('students', 'public');
                }
    
                $student->save();
                return redirect()->route('students.index')->with('success', 'Student updated successfully.');
            }
    
            // If the role is neither student nor teacher, return an error
            return redirect()->back()->with('error', 'Invalid role type.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }




    


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
