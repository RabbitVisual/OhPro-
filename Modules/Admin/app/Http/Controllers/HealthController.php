<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class HealthController extends Controller
{
    /**
     * Display system health status.
     * Includes logs and recent database activity.
     */
    public function index(): View
    {
        // 1. Read Logs
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logPath)) {
            // Read last 20KB for performance
            $content = file_get_contents($logPath, false, null, max(0, filesize($logPath) - 20480));
            $lines = explode("\n", $content);
            $logs = array_slice(array_reverse($lines), 0, 100); // Last 100 lines
        } else {
            $logs = ['Arquivo de log não encontrado.'];
        }

        // 2. Recent Activity (Audit Simulation)
        $activities = collect();

        // Users updated recently
        $users = User::latest('updated_at')->take(5)->get()->map(function ($item) {
            return [
                'type' => 'user',
                'action' => 'updated',
                'model' => $item,
                'description' => "Usuário {$item->name} foi atualizado.",
                'time' => $item->updated_at,
            ];
        });

        // Schools updated recently
        $schools = School::latest('updated_at')->take(5)->get()->map(function ($item) {
            return [
                'type' => 'school',
                'action' => 'updated',
                'model' => $item,
                'description' => "Escola {$item->name} foi atualizada.",
                'time' => $item->updated_at,
            ];
        });

         // Subscriptions updated recently
        $subscriptions = Subscription::with(['user', 'plan'])->latest('updated_at')->take(5)->get()->map(function ($item) {
            return [
                'type' => 'subscription',
                'action' => 'updated',
                'model' => $item,
                'description' => "Assinatura de {$item->user->name} (" . ($item->plan->name ?? 'Plano') . ") alterada.",
                'time' => $item->updated_at,
            ];
        });

        $activities = $users->merge($schools)->merge($subscriptions)->sortByDesc('time')->take(10);

        return view('admin::health.index', [
            'logs' => $logs,
            'activities' => $activities,
            'title' => 'Saúde do Sistema'
        ]);
    }
}
