<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\TbUsuario;

class Admin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// try{
		// 	dd(auth()->user()->hasPermissionTo('Qualquer ação'));
		// }catch(\Exception $e){
		// 	abort('404',$e->getMessage());
		// }

		if( !auth()->user()->hasRole('Administrador') ) {
			abort('401');
		}

		return $next($request);
	}
}