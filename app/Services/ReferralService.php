<?php

namespace App\Services;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReferralService
{
    /**
     * Generate a unique referral code for the user if they don't have one.
     */
    public function generateCode(User $user): string
    {
        if ($user->referral_code) {
            return $user->referral_code;
        }

        $code = strtoupper(Str::random(8));
        while (User::where('referral_code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }

        $user->update(['referral_code' => $code]);

        return $code;
    }

    /**
     * Process a referral when a new user registers with a code.
     */
    public function applyReferral(User $referee, ?string $code): ?Referral
    {
        if (!$code) {
            return null;
        }

        $referrer = User::where('referral_code', $code)->first();

        if (!$referrer || $referrer->id === $referee->id) {
            return null;
        }

        return Referral::create([
            'referrer_id' => $referrer->id,
            'referee_id' => $referee->id,
            'code_used' => $code,
            'status' => 'pending', // Waiting for subscription
        ]);
    }

    /**
     * Reward the referrer when the referee subscribes.
     */
    public function rewardReferrer(Referral $referral): void
    {
        if ($referral->status !== 'pending') {
            return;
        }

        DB::transaction(function () use ($referral) {
            $referrer = $referral->referrer;

            // Logic to extend subscription by 1 month
            // Assuming we have a method on User or Subscription model for this
            // For now, we'll just log it or update a 'credits' column if it existed
            // Ideally: $referrer->subscription()->extend(now()->addMonth());

            // If using Stripe, it's more complex (coupon or billing cycle anchor change)
            // For MVP/Local, let's assume we just mark it rewarded and maybe extend valid_until locally

            $referral->update([
                'status' => 'converted',
                'reward_granted_at' => now(),
            ]);

            // Placeholder for subscription extension logic
            // Log::info("User {$referrer->id} rewarded for referral {$referral->id}");
        });
    }
}
