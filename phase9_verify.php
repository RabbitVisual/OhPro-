<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\Admin\Models\SecurityLog;
use App\Models\User;
use Modules\ClassRecord\Notifications\StudentAtRiskAlert;
use Illuminate\Support\Facades\Notification;

echo "Starting Verification...\n";

// 1. Create Security Log
echo "1. Testing SecurityLog...\n";
try {
    $user = User::first();
    if (!$user) {
        $user = User::factory()->create();
        echo "Created temporary user for testing.\n";
    }

    // Auth for the log helper to work (it uses auth()->id())
    auth()->login($user);

    $log = SecurityLog::create([
        'user_id' => $user->id,
        'action' => 'test_action_manual',
        'description' => 'Testing Security Log creation via script.',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'TestScript/1.0',
    ]);

    // Also test the helper if possible, but keep it simple
    echo "Security Log created: ID {$log->id}\n";
} catch (\Exception $e) {
    echo "Error creating Security Log: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

// 2. Send Notification
echo "2. Testing Notification...\n";
try {
    $user = User::first();
    if ($user) {
        $student = new \stdClass();
        $student->name = "Test Student";
        $student->id = 999;

        $notification = new StudentAtRiskAlert($student, "Baixa frequência (Teste Script)");
        $user->notify($notification);
        echo "Notification sent to user {$user->id}\n";

        // Check DB
        $count = $user->notifications()->count();
        echo "User notification count: {$count}\n";
    } else {
        echo "No user found to notify.\n";
    }
} catch (\Exception $e) {
    echo "Error sending Notification: " . $e->getMessage() . "\n";
}

echo "Verification Complete.\n";
