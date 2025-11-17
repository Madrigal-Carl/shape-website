<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Address;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\Enrollment;
use App\Models\Instructor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InstructorStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get instructors with IDs 2, 3, 4, and 5
        $instructors = Instructor::whereIn('id', [2, 3, 4, 5])->get();

        foreach ($instructors as $instructor) {

            // Create 20 students assigned to this instructor
            $students = Student::factory()->count(20)->create();

            foreach ($students as $student) {

                // Get a random grade level from that instructor
                $gradeLevelId = $instructor->gradeLevels->random()->id;

                // Create student account
                Account::factory()->student($student)->create([
                    'username' => strtolower($student->first_name . $student->id),
                    'password' => 'password123',
                ]);

                // Create guardian
                Guardian::factory()->create([
                    'student_id' => $student->id
                ]);

                // Create enrollment
                Enrollment::factory()->create([
                    'instructor_id'  => $instructor->id,
                    'student_id'     => $student->id,
                    'grade_level_id' => $gradeLevelId,
                ]);

                // Permanent address
                Address::factory()->student()->create([
                    'owner_id'   => $student->id,
                    'owner_type' => Student::class,
                    'type'       => 'permanent',
                ]);

                // Current address
                Address::factory()->student()->create([
                    'owner_id'   => $student->id,
                    'owner_type' => Student::class,
                    'type'       => 'current',
                ]);
            }
        }
    }
}
