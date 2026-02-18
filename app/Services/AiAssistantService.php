<?php

namespace App\Services;

use App\Models\AiGenerationLog;
use App\Models\PortfolioEntry;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Notebook\Services\GradeService;

class AiAssistantService
{
    /**
     * Check if user can generate an AI lesson plan this month (plan limit).
     * Throws \RuntimeException with friendly message if limit exceeded.
     */
    public function ensureCanGenerateLessonPlan(User $user): void
    {
        $plan = $user->plan();
        $limit = $plan->getLimit('ai_plans_per_month');

        if ($limit === null) {
            return; // unlimited
        }

        if ((int) $limit <= 0) {
            throw new \RuntimeException('Geração de planos com IA não está disponível no seu plano atual. Faça upgrade para Pro.');
        }

        $used = AiGenerationLog::countThisMonth($user->id, AiGenerationLog::TYPE_LESSON_PLAN);
        if ($used >= (int) $limit) {
            throw new \RuntimeException("Você atingiu o limite de {$limit} planos com IA neste mês. Tente novamente no próximo mês.");
        }
    }

    /**
     * Record an AI lesson plan generation for rate limiting.
     */
    public function recordLessonPlanGeneration(User $user): void
    {
        AiGenerationLog::create([
            'user_id' => $user->id,
            'type' => AiGenerationLog::TYPE_LESSON_PLAN,
        ]);
    }

    /**
     * Get remaining AI lesson plan generations this month for the user.
     */
    public function getRemainingLessonPlanGenerations(User $user): ?int
    {
        $plan = $user->plan();
        $limit = $plan->getLimit('ai_plans_per_month');
        if ($limit === null) {
            return null; // unlimited
        }
        $limit = (int) $limit;
        if ($limit <= 0) {
            return 0;
        }
        $used = AiGenerationLog::countThisMonth($user->id, AiGenerationLog::TYPE_LESSON_PLAN);
        return max(0, $limit - $used);
    }
    /** Field keys for the "Plano Detalhado" template. */
    public const DETAILED_FIELDS = [
        'context', 'objectives', 'bncc', 'content', 'activities', 'duration',
        'resources', 'assessment', 'homework',
    ];

    /**
     * Generate lesson plan contents from subject and BNCC skill.
     * Only pedagogical context is sent; no student/school data.
     *
     * @return array<string, string> Map of field_key => value
     * @throws \RuntimeException On API or parse errors
     */
    public function generateLessonPlanContents(string $subject, string $bnccSkill): array
    {
        $driver = config('ai.driver', 'gemini');

        return match ($driver) {
            'gemini' => $this->generateWithGemini($subject, $bnccSkill),
            'openai' => $this->generateWithOpenAI($subject, $bnccSkill),
            default => throw new \RuntimeException('Driver de IA não configurado. Defina AI_DRIVER (gemini ou openai) e a chave de API correspondente.'),
        };
    }

    private function generateWithGemini(string $subject, string $bnccSkill): array
    {
        $apiKey = config('ai.gemini.api_key');
        $model = config('ai.gemini.default_model');

        if (empty($apiKey)) {
            throw new \RuntimeException('GEMINI_API_KEY não configurada no .env.');
        }

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey;

        $prompt = $this->buildPrompt($subject, $bnccSkill);

        $response = Http::timeout(60)->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 8192,
                'responseMimeType' => 'application/json',
            ],
        ]);

        if (! $response->successful()) {
            Log::warning('Gemini API error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \RuntimeException('Não foi possível gerar o plano agora. Tente novamente em instantes.');
        }

        $body = $response->json();
        $text = $body['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (empty($text)) {
            throw new \RuntimeException('Resposta da IA incompleta. Tente novamente em instantes.');
        }

        return $this->parseJsonContents($text);
    }

    private function generateWithOpenAI(string $subject, string $bnccSkill): array
    {
        $apiKey = config('ai.openai.api_key');
        $model = config('ai.openai.default_model');

        if (empty($apiKey)) {
            throw new \RuntimeException('OPENAI_API_KEY não configurada no .env.');
        }

        $url = config('ai.openai.url');
        $prompt = $this->buildPrompt($subject, $bnccSkill);

        $response = Http::withToken($apiKey)->timeout(60)->post($url, [
            'model' => $model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'response_format' => ['type' => 'json_object'],
        ]);

        if (! $response->successful()) {
            Log::warning('OpenAI API error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \RuntimeException('Não foi possível gerar o plano agora. Tente novamente em instantes.');
        }

        $body = $response->json();
        $text = $body['choices'][0]['message']['content'] ?? null;

        if (empty($text)) {
            throw new \RuntimeException('Resposta da IA incompleta. Tente novamente em instantes.');
        }

        return $this->parseJsonContents($text);
    }

    private function buildPrompt(string $subject, string $bnccSkill): string
    {
        $fieldsList = implode(', ', self::DETAILED_FIELDS);

        return <<<PROMPT
Você é um assistente pedagógico. Gere um plano de aula no formato JSON com exatamente as chaves: {$fieldsList}.

Contexto:
- Disciplina: {$subject}
- Competência/habilidade BNCC: {$bnccSkill}

Regras:
- Responda APENAS com um objeto JSON válido, sem texto antes ou depois.
- Cada chave deve ter uma string em português (conteúdo do plano).
- "duration" deve ser algo como "2 aulas de 50 min" ou "1h".
- Inclua na chave "bncc" a competência BNCC informada ou sua expansão breve.
- Seja objetivo e adequado à educação básica brasileira.

Exemplo de formato:
{"context":"...","objectives":"...","bncc":"...","content":"...","activities":"...","duration":"...","resources":"...","assessment":"...","homework":"..."}
PROMPT;
    }

    /**
     * @return array<string, string>
     */
    private function parseJsonContents(string $text): array
    {
        $text = trim($text);
        if (preg_match('/^```(?:json)?\s*([\s\S]*?)\s*```/', $text, $m)) {
            $text = trim($m[1]);
        }

        $data = json_decode($text, true);
        if (! is_array($data)) {
            throw new \RuntimeException('Resposta da IA em formato inesperado. Tente novamente em instantes.');
        }

        $result = [];
        foreach (self::DETAILED_FIELDS as $key) {
            $result[$key] = isset($data[$key]) && is_string($data[$key])
                ? $data[$key]
                : (isset($data[$key]) ? (string) $data[$key] : '');
        }

        return $result;
    }

    /**
     * Generate a one-paragraph "Relatório de Evolução Pedagógica" for a student based on timeline entries and grades.
     * Uses cycle (1-4) and current year to scope the period.
     *
     * @throws \RuntimeException On API or config errors
     */
    public function generateStudentProgressReport(Student $student, int $cycle = 1): string
    {
        if ($student->user_id !== auth()->id()) {
            abort(403);
        }

        $year = (int) date('Y');
        $monthStart = ($cycle - 1) * 3 + 1;
        $monthEnd = $cycle * 3;
        $from = sprintf('%04d-%02d-01 00:00:00', $year, $monthStart);
        $to = sprintf('%04d-%02d-23 23:59:59', $year, min(12, $monthEnd));

        $entries = PortfolioEntry::withoutGlobalScope('teacher')
            ->where('student_id', $student->id)
            ->whereBetween('occurred_at', [$from, $to])
            ->orderBy('occurred_at')
            ->get();

        $gradeService = app(GradeService::class);
        $contextParts = ["Aluno: {$student->name}. Período: ciclo {$cycle} de {$year}."];
        foreach ($student->schoolClasses as $schoolClass) {
            $grades = \App\Models\Grade::withoutGlobalScope('user')
                ->where('student_id', $student->id)
                ->where('school_class_id', $schoolClass->id)
                ->where('cycle', $cycle)
                ->get()
                ->keyBy('evaluation_type');
            $av1 = $grades->get('av1')?->score;
            $av2 = $grades->get('av2')?->score;
            $av3 = $grades->get('av3')?->score;
            $avg = $gradeService->calculateWeightedAverage($av1, $av2, $av3);
            $contextParts[] = "Turma {$schoolClass->name}: Av1=" . ($av1 ?? '—') . ', Av2=' . ($av2 ?? '—') . ', Av3=' . ($av3 ?? '—') . ", Média=" . ($avg !== null ? number_format($avg, 1, ',', '') : '—');
        }
        foreach ($entries as $e) {
            $contextParts[] = "[" . $e->occurred_at->format('d/m/Y') . "] {$e->type}: " . ($e->title ?? '') . ' — ' . ($e->content ?? '');
        }
        $context = implode("\n", $contextParts);

        $driver = config('ai.driver', 'gemini');
        if ($driver === 'gemini') {
            return $this->generateProgressReportWithGemini($context);
        }
        if ($driver === 'openai') {
            return $this->generateProgressReportWithOpenAI($context);
        }
        throw new \RuntimeException('Driver de IA não configurado.');
    }

    private function generateProgressReportWithGemini(string $context): string
    {
        $apiKey = config('ai.gemini.api_key');
        $model = config('ai.gemini.default_model');
        if (empty($apiKey)) {
            throw new \RuntimeException('GEMINI_API_KEY não configurada no .env.');
        }
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey;
        $prompt = "Com base nos dados pedagógicos abaixo, redija um único parágrafo (Relatório de Evolução Pedagógica) em português, objetivo e construtivo, para uso do professor. Não invente dados.\n\nDados:\n" . $context;
        $response = Http::timeout(30)->post($url, [
            'contents' => [['parts' => [['text' => $prompt]]]],
            'generationConfig' => ['temperature' => 0.5, 'maxOutputTokens' => 1024],
        ]);
        if (! $response->successful()) {
            Log::warning('Gemini API error', ['status' => $response->status()]);
            throw new \RuntimeException('Não foi possível gerar o relatório. Tente novamente.');
        }
        $text = $response->json('candidates.0.content.parts.0.text');
        return is_string($text) ? trim($text) : '';
    }

    private function generateProgressReportWithOpenAI(string $context): string
    {
        $apiKey = config('ai.openai.api_key');
        $model = config('ai.openai.default_model');
        if (empty($apiKey)) {
            throw new \RuntimeException('OPENAI_API_KEY não configurada no .env.');
        }
        $prompt = "Com base nos dados pedagógicos abaixo, redija um único parágrafo (Relatório de Evolução Pedagógica) em português, objetivo e construtivo, para uso do professor. Não invente dados.\n\nDados:\n" . $context;
        $response = Http::withToken($apiKey)->timeout(30)->post(config('ai.openai.url'), [
            'model' => $model,
            'messages' => [['role' => 'user', 'content' => $prompt]],
        ]);
        if (! $response->successful()) {
            Log::warning('OpenAI API error', ['status' => $response->status()]);
            throw new \RuntimeException('Não foi possível gerar o relatório. Tente novamente.');
        }
        $text = $response->json('choices.0.message.content');
        return is_string($text) ? trim($text) : '';
    }
}
