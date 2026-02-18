<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN membership ENUM('free', 'pro', 'pro_annual') NOT NULL DEFAULT 'free'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN membership ENUM('free', 'pro') NOT NULL DEFAULT 'free'");
        }
    }
};
