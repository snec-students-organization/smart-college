<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentModel;
use App\Models\SchoolClass;
use App\Models\Section;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 2. Teacher
        $teacherUser = User::create([
            'name' => 'John Teacher',
            'email' => 'teacher@school.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'is_active' => true,
        ]);
        Teacher::create([
            'user_id' => $teacherUser->id,
            'gender' => 'Male',
            'qualification' => 'M.Sc. Mathematics',
            'phone' => '1234567890',
            'address' => '123 Teacher Lane',
            'dob' => '1985-06-15',
        ]);

        // 3. Parent
        $parentUser = User::create([
            'name' => 'Jane Parent',
            'email' => 'parent@school.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
            'is_active' => true,
        ]);
        $parentProfile = ParentModel::create([
            'user_id' => $parentUser->id,
            'phone' => '0987654321',
            'address' => '456 Parent St',
        ]);

        // 4. Student
        // Ensure class/section exists
        $class = SchoolClass::firstOrCreate(['name' => 'Class 10']);
        $section = Section::firstOrCreate(['name' => 'A', 'class_id' => $class->id]);

        $studentUser = User::create([
            'name' => 'Student One',
            'email' => 'student@school.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
        ]);
        Student::create([
            'user_id' => $studentUser->id,
            'class_id' => $class->id,
            'section_id' => $section->id,
            'parent_id' => $parentProfile->id,
            'admission_no' => 'ADM2024001',
            'roll_no' => '101',
            'gender' => 'Male',
            'dob' => '2010-01-01',
            'phone' => '5555555555',
            'address' => '456 Parent St',
        ]);
    }
}
