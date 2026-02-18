<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsPro
{
    /**
     * Restrict access to Pro (or Pro Anual) subscribers only.
     * Used for PDF export and Import alunos.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isPro()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => __('Recurso disponível no plano Pro. Faça upgrade para acessar.'),
                ], 403);
            }
            return redirect()->route('billing.index')
                ->with('info', __('Recurso disponível no plano Pro. Faça upgrade para acessar.'));
        }

        return $next($request);
    }
}
