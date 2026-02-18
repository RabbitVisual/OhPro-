<?php

namespace Modules\Diary\Services;

use App\Models\ClassDiary;
use App\Models\LessonPlan;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * DiaryService for class logs: launch class (draft), sync from LessonPlan, signature and finalize.
 * A diary entry starts as draft and becomes finalized only after the teacher signs.
 */
class ClassDiaryService
{
    /**
     * Get the currently applied lesson plan for a class (most recent applied).
     */
    public function getAppliedLessonPlan(SchoolClass $schoolClass): ?LessonPlan
    {
        $pivot = $schoolClass->lessonPlans()
            ->wherePivot('status', 'applied')
            ->orderByPivot('applied_at', 'desc')
            ->first();

        return $pivot;
    }

    /**
     * Create a ClassDiary from the currently applied lesson plan for the class.
     */
    public function createFromAppliedPlan(SchoolClass $schoolClass): ClassDiary
    {
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        $plan = $this->getAppliedLessonPlan($schoolClass);
        $content = [
            'title' => null,
            'sections' => [],
            'lesson_plan_id' => null,
        ];

        if ($plan) {
            $plan->load('contents');
            $content['title'] = $plan->title;
            $content['lesson_plan_id'] = $plan->id;
            foreach ($plan->contents as $c) {
                $content['sections'][] = [
                    'field_key' => $c->field_key,
                    'value' => $c->value,
                ];
            }
        }

        return DB::transaction(function () use ($schoolClass, $content, $plan) {
            return ClassDiary::create([
                'school_class_id' => $schoolClass->id,
                'user_id' => auth()->id(),
                'lesson_plan_id' => $plan?->id,
                'started_at' => now(),
                'content' => $content,
                'is_finalized' => false,
            ]);
        });
    }

    /**
     * Save signature and optionally finalize the diary.
     */
    public function saveSignature(ClassDiary $diary, string $signatureDataUrl): string
    {
        if ($diary->user_id !== auth()->id()) {
            abort(403);
        }

        $path = 'signatures/' . uniqid('sig_', true) . '.png';
        $data = $signatureDataUrl;
        if (preg_match('#^data:image/(\w+);base64,(.+)$#', $data, $m)) {
            $data = base64_decode($m[2]);
        }
        Storage::disk('local')->put($path, $data);

        $diary->update(['signature_path' => $path]);

        return $path;
    }

    /**
     * Finalize the class diary (with signature required).
     */
    public function finalize(ClassDiary $diary): void
    {
        if ($diary->user_id !== auth()->id()) {
            abort(403);
        }
        if (empty($diary->signature_path)) {
            abort(422, 'Assinatura é obrigatória para finalizar.');
        }

        $diary->update([
            'is_finalized' => true,
            'ended_at' => now(),
            'signed_at' => now(),
        ]);
    }
}
