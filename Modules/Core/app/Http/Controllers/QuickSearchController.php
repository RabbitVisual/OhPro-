<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class QuickSearchController extends Controller
{
    /**
     * Handle quick search requests.
     */
    public function __invoke(Request $request)
    {
        $query = $request->get('q');
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = [];
        $user = auth()->user();

        // 1. Navigation (Static)
        $navItems = [
            ['title' => 'Dashboard', 'url' => route('dashboard'), 'icon' => 'home', 'subtitle' => 'Ir para o início'],
            ['title' => 'Perfil', 'url' => route('profile.edit'), 'icon' => 'user-circle', 'subtitle' => 'Minhas configurações'],
            ['title' => 'Suporte', 'url' => route('support.index'), 'icon' => 'life-ring', 'subtitle' => 'Central de ajuda'],
        ];

        foreach ($navItems as $item) {
            if (stripos($item['title'], $query) !== false) {
                $results[] = $item;
            }
        }

        // 2. Dynamic Content basic on role
        if ($user->hasRole('admin')) {
            // Search Users
            $users = User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->limit(5)
                ->get();

            foreach ($users as $u) {
                $results[] = [
                    'title' => $u->name,
                    'subtitle' => $u->email . ' (' . $u->getRoleNames()->first() . ')',
                    'url' => route('panel.admin.users.index', ['search' => $u->email]), // Ideally link to edit
                    'icon' => 'user',
                ];
            }
        }

        if ($user->hasRole('teacher')) {
            // Search Schools
            $schools = $user->schools()
                ->where('name', 'like', "%{$query}%")
                ->limit(5)
                ->get();

            foreach ($schools as $school) {
                $results[] = [
                    'title' => $school->name,
                    'subtitle' => 'Escola',
                    'url' => route('workspace.index', ['school' => $school->id]), // Hypothetical link
                    'icon' => 'school',
                ];
            }
            // Add students or classes search logic here if models exist
        }

        return response()->json($results);
    }
}
