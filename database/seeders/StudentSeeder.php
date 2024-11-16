<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    // public function run()
    // {
    //     // Ensure users exist before proceeding
    //     if (User::count() == 0) {
    //         $users = [
    //             [
    //                 'name' => 'John Doe',
    //                 'email' => 'johndoe@example.com',
    //                 'password' => Hash::make('12345678'), // Ensure to hash the password
    //                 'role' => 'teacher',
    //             ],
    //             [
    //                 'name' => 'Jane Smith',
    //                 'email' => 'janesmith@example.com',
    //                 'password' => Hash::make('12345678'),
    //                 'role' => 'teacher',
    //             ],
    //             [
    //                 'name' => 'Alice Johnson',
    //                 'email' => 'alicej@example.com',
    //                 'password' => Hash::make('12345678'),
    //                 'role' => 'student',
    //             ],
    //             [
    //                 'name' => 'Bob Williams',
    //                 'email' => 'bobw@example.com',
    //                 'password' => Hash::make('12345678'),
    //                 'role' => 'student',
    //             ],
    //         ];

    //         // Insert users
    //         User::insert($users);
    //     }


    //     // Check if no students exist
    //     if (Student::count() == 0) {
    //         $students = [
    //             [
    //                 'user_id'         => 3,
    //                 'admission_date'  => '2023-06-15',
    //                 'photo'           => 'img/team-1.jpg',
    //                 'yearly_fees'     => 20000,
    //                 // 'teacher_id	' => 1, 
    //             ],
    //             [
    //                 'user_id'         => 4,
    //                 'admission_date'  => '2022-07-20',
    //                 'photo'           => 'img/team-3.jpg',
    //                 'yearly_fees'     => 25000,
    //                 // 'teacher_id	' => 2, // Linking to teacher with ID 2
    //             ],
    //         ];

    //         Student::insert($students);
    //     }
    // }

    public function run()
    {
        // Create 20 student records
        Student::factory()->count(20)->create();
    }
}
