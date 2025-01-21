<?php

namespace Dash\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
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
        if (empty(request('lang'))) {
            return redirect(url()->current() . '?lang=' . session('DASHBOARD_CURRENT_LANG', config('dash.DEFAULT_LANG')));
        } elseif (!empty(session('DASHBOARD_CURRENT_LANG')) && session('DASHBOARD_CURRENT_LANG') != request('lang')) {
            return redirect(url()->current() . '?lang=' . session('DASHBOARD_CURRENT_LANG', config('dash.DEFAULT_LANG')));
        }
        return $next($request);
    }
}
