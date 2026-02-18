<?php

namespace Modules\Planning\Database\Seeders;

use App\Models\LessonPlanTemplate;
use Illuminate\Database\Seeder;

class PlanningDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'key' => 'simple',
                'name' => 'Plano Simples',
                'description' => 'Objetivos, conteúdo e duração.',
                'structure' => [
                    [
                        'title' => 'Objetivos e conteúdo',
                        'description' => '',
                        'fields' => [
                            ['key' => 'objectives', 'label' => 'Objetivos', 'type' => 'textarea'],
                            ['key' => 'content', 'label' => 'Conteúdo', 'type' => 'textarea'],
                            ['key' => 'duration', 'label' => 'Duração', 'type' => 'text'],
                        ],
                    ],
                ],
                'is_system' => true,
            ],
            [
                'key' => 'detailed',
                'name' => 'Plano Detalhado',
                'description' => 'Contexto, competências BNCC, recursos, avaliação.',
                'structure' => [
                    [
                        'title' => 'Contexto',
                        'description' => 'Contexto da turma',
                        'fields' => [
                            ['key' => 'context', 'label' => 'Contexto da turma', 'type' => 'textarea'],
                        ],
                    ],
                    [
                        'title' => 'Objetivos e competências',
                        'description' => '',
                        'fields' => [
                            ['key' => 'objectives', 'label' => 'Objetivos', 'type' => 'textarea'],
                            ['key' => 'bncc', 'label' => 'Competências BNCC', 'type' => 'textarea'],
                        ],
                    ],
                    [
                        'title' => 'Conteúdo e atividades',
                        'description' => '',
                        'fields' => [
                            ['key' => 'content', 'label' => 'Conteúdo', 'type' => 'textarea'],
                            ['key' => 'activities', 'label' => 'Atividades', 'type' => 'textarea'],
                            ['key' => 'duration', 'label' => 'Duração', 'type' => 'text'],
                        ],
                    ],
                    [
                        'title' => 'Recursos e avaliação',
                        'description' => '',
                        'fields' => [
                            ['key' => 'resources', 'label' => 'Recursos', 'type' => 'textarea'],
                            ['key' => 'assessment', 'label' => 'Avaliação', 'type' => 'textarea'],
                            ['key' => 'homework', 'label' => 'Tarefa de casa', 'type' => 'textarea'],
                        ],
                    ],
                ],
                'is_system' => true,
            ],
        ];

        foreach ($templates as $t) {
            LessonPlanTemplate::updateOrCreate(
                ['key' => $t['key']],
                $t
            );
        }
    }
}
