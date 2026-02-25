<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WorkspaceRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_workspace_route(): void
    {
        $this->withoutExceptionHandling();
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'teacher']);
        $user = User::factory()->create();
        $user->assignRole('teacher');

        $response = $this->actingAs($user)->get('/workspace');
        $response->assertStatus(200);
    }
}
