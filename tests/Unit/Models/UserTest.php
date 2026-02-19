<?php

namespace Tests\Unit\Models;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_plan_returns_free_plan_by_default(): void
    {
        Plan::factory()->create(['key' => 'free']);
        $user = User::factory()->create();

        $this->assertEquals('free', $user->plan()->key);
    }

    public function test_plan_returns_subscribed_plan(): void
    {
        Plan::factory()->create(['key' => 'free']);
        $proPlan = Plan::factory()->create(['key' => 'pro']);
        $user = User::factory()->create();

        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $proPlan->id,
            'status' => 'active',
        ]);

        $this->assertEquals('pro', $user->plan()->key);
    }

    public function test_plan_returns_latest_active_subscription(): void
    {
        Plan::factory()->create(['key' => 'free']);
        $plan1 = Plan::factory()->create(['key' => 'pro_monthly']);
        $plan2 = Plan::factory()->create(['key' => 'pro_annual']);
        $user = User::factory()->create();

        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan1->id,
            'status' => 'active',
            'created_at' => now()->subDay(),
        ]);

        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan_id' => $plan2->id,
            'status' => 'active',
            'created_at' => now(),
        ]);

        $this->assertEquals('pro_annual', $user->plan()->key);
    }

    public function test_is_free_returns_true_when_membership_is_free(): void
    {
        $user = User::factory()->create(['membership' => 'free']);
        $this->assertTrue($user->isFree());
    }

    public function test_is_free_returns_true_when_no_active_subscription(): void
    {
        $user = User::factory()->create(['membership' => 'pro']);

        // No subscription
        $this->assertTrue($user->isFree());

        // Inactive subscription
        Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'canceled',
        ]);
        $this->assertTrue($user->isFree());
    }

    public function test_is_free_returns_false_when_has_active_subscription_and_not_free_membership(): void
    {
        $user = User::factory()->create(['membership' => 'pro']);
        Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $this->assertFalse($user->isFree());
    }

    public function test_is_pro_returns_true_when_pro_membership_and_active_subscription(): void
    {
        $user = User::factory()->create(['membership' => 'pro']);
        Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $this->assertTrue($user->isPro());

        $user->membership = 'pro_annual';
        $this->assertTrue($user->isPro());
    }

    public function test_is_pro_returns_false_when_not_pro_membership(): void
    {
        $user = User::factory()->create(['membership' => 'free']);
        Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $this->assertFalse($user->isPro());
    }

    public function test_is_pro_returns_false_when_inactive_subscription(): void
    {
        $user = User::factory()->create(['membership' => 'pro']);
        Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'canceled',
        ]);

        $this->assertFalse($user->isPro());
    }

    public function test_within_limit_returns_true_if_limit_is_null(): void
    {
        $plan = Plan::factory()->create(['key' => 'free', 'limits' => null]);
        $user = User::factory()->create();

        $this->assertTrue($user->withinLimit('max_classes', 100));
    }

    public function test_within_limit_returns_true_if_under_limit(): void
    {
        $plan = Plan::factory()->create(['key' => 'free', 'limits' => ['max_classes' => 10]]);
        $user = User::factory()->create();

        $this->assertTrue($user->withinLimit('max_classes', 5));
    }

    public function test_within_limit_returns_false_if_at_or_over_limit(): void
    {
        $plan = Plan::factory()->create(['key' => 'free', 'limits' => ['max_classes' => 10]]);
        $user = User::factory()->create();

        $this->assertFalse($user->withinLimit('max_classes', 10));
        $this->assertFalse($user->withinLimit('max_classes', 11));
    }

    public function test_has_feature_returns_true_if_feature_exists(): void
    {
        $plan = Plan::factory()->create(['key' => 'free', 'features' => ['ai_generation']]);
        $user = User::factory()->create();

        $this->assertTrue($user->hasFeature('ai_generation'));
    }

    public function test_has_feature_returns_false_if_feature_does_not_exist(): void
    {
        $plan = Plan::factory()->create(['key' => 'free', 'features' => ['ai_generation']]);
        $user = User::factory()->create();

        $this->assertFalse($user->hasFeature('premium_templates'));
    }
}
