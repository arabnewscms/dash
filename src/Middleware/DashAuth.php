<?php
namespace Dash\Middleware;

use Closure;
use Illuminate\Http\Request;

class DashAuth {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next) {
		if (!auth()->guard('dash')->check()) {
			return redirect(app('dash')['DASHBOARD_PATH'].'/login');
		}
		return $next($request);
	}
}
