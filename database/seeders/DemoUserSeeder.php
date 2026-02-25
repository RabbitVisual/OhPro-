<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersToCreate = [
            [
                'email' => 'admin@ohpro.com.br',
                'first_name' => 'Admin',
                'username' => 'admin_demo',
                'role' => 'admin',
            ],
            [
                'email' => 'suporte@ohpro.com.br',
                'first_name' => 'Suporte',
                'username' => 'suporte_demo',
                'role' => 'support',
            ],
            [
                'email' => 'professor@ohpro.com.br',
                'first_name' => 'Professor',
                'username' => 'professor_demo',
                'role' => 'teacher',
            ],
        ];

        foreach ($usersToCreate as $idx => $userData) {
            $cpfPrefix = str_repeat((string)($idx + 1), 11); // 11111111111, 22222222222, 33333333333
            $demoUser = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'first_name' => $userData['first_name'],
                    'last_name' => 'Demo',
                    'username' => $userData['username'],
                    'password' => Hash::make('password'),
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'membership' => 'pro',
                    'cpf' => $cpfPrefix, // Unique dummy cpf avoiding 00000000000
                ]
            );

            if (\Spatie\Permission\Models\Role::where('name', $userData['role'])->exists()) {
                $demoUser->syncRoles([$userData['role']]);
            }
        }

        $this->command->info('Os 3 Usuários Demo (Admin, Suporte, Professor) foram criados com sucesso.');
    }
}
