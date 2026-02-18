<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users (Teachers/Managers).
     */
    public function index(): View
    {
        $users = User::role(['teacher', 'manager'])
            ->with(['roles', 'subscriptions.plan'])
            ->latest()
            ->paginate(15);

        return view('admin::users.index', [
            'users' => $users,
            'title' => 'Gerenciar Usuários'
        ]);
    }

    /**
     * Manually upgrade a user to the Pro plan.
     */
    public function upgradeToPro(User $user)
    {
        $proPlan = Plan::where('key', 'pro')->first();

        if (!$proPlan) {
            return back()->with('error', 'Plano Pro não encontrado.');
        }

        // Create or update subscription
        $user->subscriptions()->updateOrCreate(
            [
                'plan_id' => $proPlan->id,
            ],
            [
                'status' => 'active',
                'current_period_start' => now(),
                'current_period_end' => now()->addMonth(),
            ]
        );

        return back()->with('success', "Usuário {$user->name} promovido para Pro com sucesso!");
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin::users.edit', [
            'user' => $user,
            'title' => 'Editar Usuário: ' . $user->name,
            'roles' => \Spatie\Permission\Models\Role::all(),
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('panel.admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }
}
