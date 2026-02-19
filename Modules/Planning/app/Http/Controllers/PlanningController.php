<?php

namespace Modules\Planning\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LessonPlan;
use App\Services\AiAssistantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Planning\Services\LessonPlanService;

class PlanningController extends Controller
{
    public function __construct(
        private LessonPlanService $lessonPlanService,
        private AiAssistantService $aiAssistant
    ) {}

    public function index(): View
    {
        return view('planning::index');
    }

    public function community(): View
    {
        $plans = \App\Models\LessonPlan::withoutGlobalScope('user')
            ->public()
            ->with('contents')
            ->orderByDesc('updated_at')
            ->paginate(12);
        return view('planning::community', compact('plans'));
    }

    public function clone(int $id): RedirectResponse
    {
        $source = \App\Models\LessonPlan::withoutGlobalScope('user')->public()->with('contents')->find($id);
        if (! $source) {
            return redirect()->route('planning.index')->with('error', 'Plano não encontrado ou não está disponível para clonar.');
        }
        $newPlan = $this->lessonPlanService->cloneFrom($source);
        return redirect()->route('planning.edit', $newPlan->id)->with('success', 'Plano clonado. Ajuste o título e o conteúdo se desejar.');
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

    /**
     * Generate a lesson plan with AI and create it, then redirect to edit.
     */
    public function generateWithAi(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'bncc_skill' => 'required|string|max:2000',
        ]);

        $user = $request->user();
        try {
            $this->aiAssistant->ensureCanGenerateLessonPlan($user);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 429);
        }

        try {
            $contents = $this->aiAssistant->generateLessonPlanContents(
                $validated['subject'],
                $validated['bncc_skill']
            );
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $title = $validated['subject'] . ' (IA)';
        if (strlen($title) > 255) {
            $title = substr($validated['subject'], 0, 250) . ' (IA)';
        }
        $plan = $this->lessonPlanService->createFromAi($title, $contents);
        $this->aiAssistant->recordLessonPlanGeneration($user);

        return response()->json([
            'redirect' => route('planning.edit', $plan->id),
            'message' => 'Plano gerado com IA. Revise e salve se precisar de ajustes.',
        ]);
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
            'is_public' => 'nullable|boolean',
        ]);
        $plan->update([
            'title' => $validated['title'],
            'notes' => $validated['notes'] ?? null,
            'is_public' => $request->boolean('is_public'),
        ]);

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

    public function downloadPdf(int $id)
    {
        $plan = \App\Models\LessonPlan::with(['contents', 'user'])->findOrFail($id);

        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }

        $service = new \Modules\ClassRecord\Services\PdfReportService();

        $pdfContent = $service->generateFromView('planning::pdf', [
            'plan' => $plan,
        ], false, [
            'watermark' => 'Licenciado para ' . auth()->user()->name,
        ]);

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . \Illuminate\Support\Str::slug($plan->title) . '.pdf"');
    }
}
