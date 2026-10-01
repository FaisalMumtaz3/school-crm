<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use App\Models\SchoolPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create a demo school
        $school = School::create([
            'name' => 'Demo School',
            'code' => 'DEMO001',
            'email' => 'school@demo.com',
            'phone' => '+923001234567',
            'address' => '123 Main Street, City',
            'status' => 'active',
        ]);

        // Create school admin user
        $schoolAdmin = User::create([
            'name' => 'School Admin',
            'email' => 'schooladmin@demo.com',
            'password' => Hash::make('password'),
            'school_id' => $school->id,
            'role' => 'school_admin',
            'is_active' => true,
        ]);

        // Create staff user
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@demo.com',
            'password' => Hash::make('password'),
            'school_id' => $school->id,
            'role' => 'staff',
            'is_active' => true,
        ]);

        // Create default permissions for the school
        foreach (SchoolPermission::availableFeatures() as $feature => $label) {
            SchoolPermission::create([
                'school_id' => $school->id,
                'feature' => $feature,
                'enabled' => true,
            ]);
        }

        // Create some sample data
        $class1 = \App\Models\SchoolClass::create([
            'school_id' => $school->id,
            'name' => 'Grade 1',
        ]);

        $class2 = \App\Models\SchoolClass::create([
            'school_id' => $school->id,
            'name' => 'Grade 2',
        ]);

        $section1 = \App\Models\Section::create([
            'school_id' => $school->id,
            'name' => 'A',
        ]);

        $section2 = \App\Models\Section::create([
            'school_id' => $school->id,
            'name' => 'B',
        ]);

        // Create sample students
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Student::create([
                'school_id' => $school->id,
                'name' => "Student {$i}",
                'father_name' => "Father {$i}",
                'phone' => '+92300123456' . $i,
                'class' => $class1->id,
                'section' => $section1->id,
                'roll_number' => $i,
                'admission_date' => now()->subDays(rand(1, 365)),
            ]);
        }

        // Create sample teachers
        for ($i = 1; $i <= 3; $i++) {
            \App\Models\Teacher::create([
                'school_id' => $school->id,
                'name' => "Teacher {$i}",
                'father_name' => "Father {$i}",
                'phone' => '+92300555555' . $i,
                'qualification' => 'M.Ed',
                'subject' => ['Math', 'Science', 'English'][$i - 1],
                'salary' => 50000 + ($i * 5000),
                'joining_date' => now()->subMonths(rand(1, 24)),
            ]);
        }
    }
}