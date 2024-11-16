<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     if (Teacher::count() == 0) {
    //         $teachers = [
    //             [
    //                 'user_id'   => 1,
    //                 'photo'     => 'img/team-1.jpg',
    //                 'subject'   => 'Java',
    //             ],
    //             [
    //                 'user_id'   => 2,
    //                 'photo'     => 'img/team-2.jpg',
    //                 'subject'   => 'Python',
    //             ],
    //         ];

    //         Teacher::insert($teachers);
    //     }
    // }

    public function run()
    {
        // Insert 10 records using a factory
        Teacher::factory()->count(10)->create();
    }
}
