<?php

namespace Tests\Feature;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class ImportBenchmarkTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_performance()
    {
        // Setup: Add email column if it doesn't exist (to allow the test to run)
        if (!Schema::hasColumn('students', 'email')) {
            Schema::table('students', function ($table) {
                $table->string('email')->nullable()->index();
            });
        }

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($user);

        $school = School::create([
            'name' => 'Test School',
            'user_id' => $user->id,
        ]);

        $schoolClass = SchoolClass::create([
            'name' => 'Test Class',
            'user_id' => $user->id,
            'school_id' => $school->id,
        ]);

        $studentsData = [];
        for ($i = 0; $i < 100; $i++) {
            $studentsData[] = [
                'id' => "google_id_$i",
                'name' => "Student $i",
                'email' => "student$i@example.com",
            ];
        }

        $selectedStudents = array_column($studentsData, 'id');

        DB::enableQueryLog();
        $start = microtime(true);

        // This simulates the logic in ImportGoogleRoster::import()
        $count = 0;
        foreach ($studentsData as $s) {
            if (in_array($s['id'], $selectedStudents)) {
                // Find or create student
                $student = Student::firstOrCreate(
                    ['email' => $s['email']],
                    [
                        'name' => $s['name'],
                        'user_id' => auth()->id(),
                    ]
                );

                // Attach to class if not already
                if (!$schoolClass->students()->where('student_id', $student->id)->exists()) {
                    $schoolClass->students()->attach($student->id);
                    $count++;
                }
            }
        }

        $end = microtime(true);
        $queries = DB::getQueryLog();

        echo "\nBaseline:\n";
        echo "Time: " . ($end - $start) . "s\n";
        echo "Queries: " . count($queries) . "\n";
        echo "Imported: $count\n";

        $this->assertEquals(100, $count);
    }
}
