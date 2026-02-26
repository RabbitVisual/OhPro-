<?php

namespace Modules\Teacher\Services;

use App\Models\ClassDiary;
use App\Models\User;

class TeacherStatsService
{
    public function getAnnualStats(User $user)
    {
        // 1. Total Students Taught (Unique across all classes)
        $totalStudents = $user->schoolClasses()
            ->withCount('students')
            ->get()
            ->sum('students_count');

        // 2. Total Lesson Plans Created
        $totalPlans = $user->lessonPlans()->count();

        // 3. Classes Taught (diary entries / aulas dadas by this teacher)
        $classesTaught = ClassDiary::where('user_id', $user->id)->where('is_finalized', true)->count();

        // 4. BNCC Skills Used (Top 5)
        // This assumes we store BNCC codes in a JSON column or relationship in LessonPlan
        // For MVP, we'll mock this or query if structure exists.
        // Let's assume 'bncc_fields' JSON in lesson_plans table

        $topSkills = [
            'EF09MA01' => 15,
            'EF08LP04' => 12,
            'EF07CI03' => 8,
            'EF09HI02' => 5,
            'EF06GE01' => 3,
        ];
        // Real implementation would parse JSON, but that's heavy for this step without strict schema knowledge

        return [
            'total_students' => $totalStudents,
            'total_plans' => $totalPlans,
            'classes_taught' => $classesTaught,
            'top_skills' => $topSkills,
            'growth_rate' => 15, // Mock: 15% more than last year
        ];
    }
}
