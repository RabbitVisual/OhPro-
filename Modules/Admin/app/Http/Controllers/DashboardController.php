<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with cached metrics.
     */
    public function index(): View
    {
        $metrics = Cache::remember('admin.dashboard.metrics', 600, function () {
            // Active Teachers (User with role teacher)
            $teachersCount = User::role('teacher')->count();

            // Total Schools
            $schoolsCount = School::count();

            // MRR (Monthly Recurring Revenue)
            // Consider active subscriptions and their plans
            $mrr = Subscription::query()
                ->where('status', 'active') // Ensure we have a scope or active status check
                ->with('plan')
                ->get()
                ->sum(function ($subscription) {
                    if (!$subscription->plan) {
                        return 0;
                    }

                    // If plan interval is yearly, divide by 12 for MRR representation
                    if ($subscription->plan->interval === 'yearly') {
                        return $subscription->plan->price_yearly / 12;
                    }

                    return $subscription->plan->price_monthly;
                });

            return [
                'teachers_count' => $teachersCount,
                'schools_count' => $schoolsCount,
                'mrr' => $mrr,
            ];
        });

        return view('admin::dashboard', [
            'metrics' => $metrics,
            'title' => 'Dashboard'
        ]);
    }
}
