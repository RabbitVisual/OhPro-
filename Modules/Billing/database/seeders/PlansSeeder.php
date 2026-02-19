<?php

namespace Modules\Billing\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'key' => 'free',
                'name' => 'Gratuito',
                'description' => 'Para começar. Tudo que você precisa para organizar uma turma.',
                'price_monthly' => 0,
                'price_yearly' => null,
                'interval' => 'month',
                'features' => json_encode([
                    '1 escola',
                    'Até 3 turmas',
                    'Workspace e turmas',
                    '5 Planos de aula com IA',
                    'Notas em planilha',
                    'Chamada rápida',
                    'Diário com assinatura digital',
                    'Widget Próxima Aula',
                ]),
                'limits' => json_encode(['max_schools' => 1, 'max_classes' => 3, 'ai_plans_per_month' => 5]),
                'stripe_price_id' => null,
                'stripe_price_yearly_id' => null,
                'mercadopago_plan_id' => null,
                'sort' => 1,
                'is_active' => true,
            ],
            [
                'key' => 'pro',
                'name' => 'Pro',
                'description' => 'Para quem dá aula em várias turmas e quer mais produtividade.',
                'price_monthly' => 29.90,
                'price_yearly' => 299.00,
                'interval' => 'month',
                'features' => json_encode([
                    'Até 3 escolas',
                    'Até 20 turmas',
                    '50 Planos de aula com IA',
                    'Exportação de relatórios',
                    'Suporte prioritário',
                    'Cancele quando quiser',
                ]),
                'limits' => json_encode(['max_schools' => 3, 'max_classes' => 20, 'ai_plans_per_month' => 50]),
                'stripe_price_id' => null,
                'stripe_price_yearly_id' => null,
                'mercadopago_plan_id' => null,
                'sort' => 2,
                'is_active' => true,
            ],
            [
                'key' => 'pro_annual',
                'name' => 'Pro Anual',
                'description' => 'Melhor custo-benefício. Pague anual e ganhe 2 meses.',
                'price_monthly' => 24.90,
                'price_yearly' => 298.80,
                'interval' => 'year',
                'features' => json_encode([
                    'Tudo do Pro Mensal',
                    '2 meses grátis no ano',
                    'Cobrança anual única',
                    'Suporte prioritário',
                ]),
                'limits' => json_encode(['max_schools' => 3, 'max_classes' => 20, 'ai_plans_per_month' => 50]),
                'stripe_price_id' => null,
                'stripe_price_yearly_id' => null,
                'mercadopago_plan_id' => null,
                'sort' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            DB::table('plans')->updateOrInsert(
                ['key' => $plan['key']],
                array_merge($plan, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
