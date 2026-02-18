<?php

namespace Modules\Workspace\Database\Seeders;

use App\Models\School;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;

class WorkspaceDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            return;
        }

        $school1 = School::firstOrCreate(
            ['user_id' => $user->id, 'name' => 'Escola Demo A'],
            ['short_name' => 'EDA', 'color' => '#6366f1', 'timezone' => 'America/Sao_Paulo']
        );
        $school2 = School::firstOrCreate(
            ['user_id' => $user->id, 'name' => 'Escola Demo B'],
            ['short_name' => 'EDB', 'color' => '#10b981', 'timezone' => 'America/Sao_Paulo']
        );

        foreach ([$school1, $school2] as $school) {
            SchoolClass::firstOrCreate(
                ['user_id' => $user->id, 'school_id' => $school->id, 'name' => 'Turma 1'],
                ['grade_level' => '1º ano', 'subject' => 'Matemática', 'year' => now()->year]
            );
            SchoolClass::firstOrCreate(
                ['user_id' => $user->id, 'school_id' => $school->id, 'name' => 'Turma 2'],
                ['grade_level' => '2º ano', 'subject' => 'Português', 'year' => now()->year]
            );
        }
    }
}
