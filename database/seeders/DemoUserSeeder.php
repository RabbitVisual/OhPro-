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
        $demoUser = User::updateOrCreate(
            ['email' => 'demo@ohpro.com.br'],
            [
                'first_name' => 'Demo',
                'last_name' => 'User',
                'username' => 'demo_user',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => now(),
                'membership' => 'pro', // assuming a pro membership for demo purposes
                'cpf' => '00000000000',
            ]
        );

        // Assign multiple roles to the demo user
        $roles = collect(['admin', 'support', 'teacher'])->filter(function ($role) {
            return \Spatie\Permission\Models\Role::where('name', $role)->exists();
        });

        $demoUser->syncRoles($roles);

        $this->command->info('Usuário Demo criado com sucesso (demo@ohpro.com.br / password) com os papéis: ' . $roles->implode(', '));
    }
}
