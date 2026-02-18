<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $plans = Plan::ordered()->get();

        return view('admin::plans.index', [
            'plans' => $plans,
            'title' => 'Gerenciar Planos',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan): View
    {
        return view('admin::plans.edit', [
            'plan' => $plan,
            'title' => 'Editar Plano: '.$plan->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly' => 'nullable|numeric|min:0',
            'limits.max_schools' => 'nullable|integer|min:-1',
            'limits.max_classes' => 'nullable|integer|min:-1',
            'limits.ai_plans_per_month' => 'nullable|integer|min:-1',
        ]);

        // Merge existing limits with new ones to avoid data loss on other keys
        $currentLimits = $plan->limits ?? [];
        $newLimits = $request->input('limits', []);

        // Ensure integer types for limits
        foreach ($newLimits as $key => $value) {
            $newLimits[$key] = $value === null ? null : (int) $value;
        }

        $plan->update([
            'price_monthly' => $validated['price_monthly'],
            'price_yearly' => $validated['price_yearly'],
            'limits' => array_merge($currentLimits, $newLimits),
        ]);

        return redirect()->route('panel.admin.plans.index')
            ->with('success', 'Plano atualizado com sucesso!');
    }
}
