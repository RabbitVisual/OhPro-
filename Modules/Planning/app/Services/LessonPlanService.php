<?php

namespace Modules\Planning\Services;

use App\Models\LessonPlan;
use App\Models\LessonPlanContent;
use App\Models\LessonPlanTemplate;
use Illuminate\Support\Facades\DB;

class LessonPlanService
{
    /**
     * Create a new lesson plan and insert content rows from the template's field_keys.
     */
    public function create(array $data): LessonPlan
    {
        $data = validator($data, [
            'title' => 'required|string|max:255',
            'template_key' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ])->validate();

        $template = LessonPlanTemplate::where('key', $data['template_key'])->firstOrFail();
        $fieldKeys = $this->extractFieldKeysFromStructure($template->structure);

        return DB::transaction(function () use ($data, $template, $fieldKeys) {
            $plan = LessonPlan::create([
                'user_id' => auth()->id(),
                'title' => $data['title'],
                'template_key' => $template->key,
                'sections' => [],
                'notes' => $data['notes'] ?? null,
            ]);

            $sortOrder = 0;
            foreach ($fieldKeys as $key) {
                LessonPlanContent::create([
                    'lesson_plan_id' => $plan->id,
                    'field_key' => $key,
                    'value' => null,
                    'sort_order' => $sortOrder++,
                ]);
            }

            return $plan->load('contents');
        });
    }

    /**
     * Update content values by field_key.
     */
    public function updateContents(LessonPlan $plan, array $contentsByKey): void
    {
        if ($plan->user_id !== auth()->id()) {
            abort(403);
        }

        foreach ($contentsByKey as $fieldKey => $value) {
            LessonPlanContent::where('lesson_plan_id', $plan->id)
                ->where('field_key', $fieldKey)
                ->update(['value' => $value]);
        }
    }

    /**
     * Extract field keys from template structure (sections[].fields[].key or flat list).
     */
    private function extractFieldKeysFromStructure(array $structure): array
    {
        $keys = [];
        foreach ($structure as $section) {
            if (isset($section['fields']) && is_array($section['fields'])) {
                foreach ($section['fields'] as $field) {
                    if (!empty($field['key'])) {
                        $keys[] = $field['key'];
                    }
                }
            }
        }
        return $keys ?: ['objectives', 'content', 'duration'];
    }
}
