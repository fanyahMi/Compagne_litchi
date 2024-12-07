<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleAgentEntree
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

        $role = $request->session()->get('agent.role');
        if ($role !== "Administrateur" && $role !== "Agent_entree"  && $role !== "Agent_sortie") {
            abort(403, 'Accès interdit');
        }


        return $next($request);
    }
}
