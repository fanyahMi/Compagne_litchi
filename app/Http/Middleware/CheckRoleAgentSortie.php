<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleAgentSortie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (!$request->session()->has('agent')) {
            return redirect()->route('login');
        }

        if ($request->session()->get('agent.role') !== "Agent_sortie" && $request->session()->get('agent.role') !== "Administrateur") {
            abort(403, 'Accès interdit');
        }

        return $next($request);
    }
}
