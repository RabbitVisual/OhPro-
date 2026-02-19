<?php

namespace Tests\Feature;

use App\Models\LessonPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PlanningAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create the teacher role required for access
        Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
    }

    public function test_user_cannot_access_another_users_lesson_plan(): void
    {
        $user1 = User::factory()->create();
        $user1->assignRole('teacher');

        $user2 = User::factory()->create();
        $user2->assignRole('teacher');

        $plan = LessonPlan::create([
            'user_id' => $user1->id,
            'title' => 'Plano do User 1',
            'template_key' => 'simple',
            'sections' => [],
        ]);

        $response = $this->actingAs($user2)->get(route('planning.edit', $plan->id));

        $response->assertRedirect(route('planning.index'));
        $response->assertSessionHas('error');
    }

    public function test_user_can_access_own_lesson_plan(): void
    {
        $user = User::factory()->create();
        $user->assignRole('teacher');

        $plan = LessonPlan::create([
            'user_id' => $user->id,
            'title' => 'Meu plano',
            'template_key' => 'simple',
            'sections' => [],
        ]);

        $response = $this->actingAs($user)->get(route('planning.edit', $plan->id));

        $response->assertOk();
    }
}
