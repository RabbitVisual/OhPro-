<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TeacherDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_dashboard_loads_correctly()
    {
        // Ensure the teacher role exists
        Role::firstOrCreate(['name' => 'teacher']);

        $teacher = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $teacher->assignRole('teacher');

        // Note: For a more thorough test, factories for SchoolClass, LessonPlan, and Notification could be used here.
        // But for structural validation, we just want to ensure it passes data to the view without errors.

        $this->withoutMiddleware();
        $response = $this->actingAs($teacher)->get('/dashboard');

        if ($response->status() === 302) {
            dump($response->headers->get('Location'));
        }

        $response->assertStatus(200);
        $response->assertViewIs('teacher::dashboard');

        // Assert view has the data we expect
        $response->assertViewHasAll([
            'activeClassesCount',
            'lessonPlansCount',
            'nextClass',
            'recentNotifications',
        ]);
    }
}
