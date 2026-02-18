<?php

namespace Modules\Planning\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LessonPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Planning\Services\LessonPlanService;

class PlanningController extends Controller
{
    public function __construct(
        private LessonPlanService $lessonPlanService
    ) {}

    public function index(): View
    {
        return view('planning::index');
    }

    public function create(): View
    {
        $templates = \App\Models\LessonPlanTemplate::orderBy('name')->get();
        return view('planning::create', compact('templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'template_key' => 'required|string|max:50|exists:lesson_plan_templates,key',
            'notes' => 'nullable|string',
        ]);

        $plan = $this->lessonPlanService->create($validated);
        return redirect()->route('planning.edit', $plan->id)->with('success', 'Plano criado.');
    }

    public function show(int $id): View|RedirectResponse
    {
        $plan = $this->findPlan($id);
        if (!$plan) {
            return redirect()->route('planning.index')->with('error', 'Plano não encontrado.');
        }
        $plan->load('contents');
        return view('planning::show', ['plan' => $plan]);
    }

    public function edit(int $id): View|RedirectResponse
    {
        $plan = $this->findPlan($id);
        if (!$plan) {
            return redirect()->route('planning.index')->with('error', 'Plano não encontrado.');
        }
        $plan->load('contents');
        return view('planning::edit', ['plan' => $plan]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $plan = $this->findPlan($id);
        if (!$plan) {
            return redirect()->route('planning.index')->with('error', 'Plano não encontrado.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);
        $plan->update($validated);

        if ($request->has('contents') && is_array($request->contents)) {
            $this->lessonPlanService->updateContents($plan, $request->contents);
        }

        return redirect()->route('planning.edit', $plan->id)->with('success', 'Plano atualizado.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $plan = $this->findPlan($id);
        if (!$plan) {
            return redirect()->route('planning.index')->with('error', 'Plano não encontrado.');
        }
        $plan->delete();
        return redirect()->route('planning.index')->with('success', 'Plano removido.');
    }

    private function findPlan(int $id): ?LessonPlan
    {
        return LessonPlan::where('user_id', auth()->id())->find($id);
    }
}
