<?php

namespace Tests\Feature;

use App\Models\LessonPlan;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanningAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_another_users_lesson_plan(): void
    {
        $this->seed(RoleSeeder::class);

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
        $this->seed(RoleSeeder::class);

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
