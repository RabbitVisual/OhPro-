<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Roles used for panel access: teacher, admin, support.
     * Guard 'web' must match the guard used by your auth.
     */
    public function run(): void
    {
        $guard = config('auth.defaults.guard', 'web');

        foreach (['teacher', 'admin', 'support'] as $name) {
            Role::firstOrCreate(
                ['name' => $name, 'guard_name' => $guard],
                ['name' => $name, 'guard_name' => $guard]
            );
        }
    }
}
