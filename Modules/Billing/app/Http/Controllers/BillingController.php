<?php

namespace Modules\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Billing\Services\BillingService;

class BillingController extends Controller
{
    public function index(Request $request, BillingService $billing): View
    {
        $user = $request->user();
        $subscription = $user->subscription();
        $plan = $user->plan();
        $plans = Plan::active()->ordered()->get();
        $preferredPlanKey = $request->query('plan'); // from /planos or link

        return view('billing::index', [
            'subscription' => $subscription,
            'currentPlan' => $plan,
            'plans' => $plans,
            'preferredPlanKey' => $preferredPlanKey,
        ]);
    }

    public function checkout(Request $request, BillingService $billing): RedirectResponse
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'interval' => 'required|in:month,year',
            'gateway' => 'nullable|in:stripe,mercadopago',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        if ($plan->isFree()) {
            return redirect()->route('billing.index')->with('error', 'Plano gratuito não requer assinatura.');
        }

        $user = $request->user();
        $gateway = $request->input('gateway');

        try {
            $url = $billing->createCheckout($user, $plan, $request->interval, $gateway);
            return redirect()->away($url);
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('billing.index')->with('error', 'Configure os IDs de preço do Stripe/Mercado Pago para este plano.');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('billing.index')->with('error', 'Não foi possível iniciar o checkout. Tente novamente.');
        }
    }

    public function success(Request $request): RedirectResponse
    {
        return redirect()->route('billing.index')->with('success', 'Assinatura ativada com sucesso! O webhook atualizará seu plano em instantes.');
    }

    public function cancel(): RedirectResponse
    {
        return redirect()->route('billing.index')->with('info', 'Checkout cancelado. Você pode assinar quando quiser.');
    }
}
