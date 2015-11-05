<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Carbon\Carbon;

class Activate
{

	protected $auth;


	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	public function handle($request, Closure $next)
	{
		//si désactivé => on envoie chier
		if (!$this->auth->user()->active) {
			return response('Ton compte est désactivé. Contacte un DDP\'s');
			// Un message à été envoyé aux DDP\'s et tu seras contacté par mail lorsque ton compte aura été ré-activé.');
		}

		// Première connexion
		if (is_null($this->auth->user()->connected_at)) {
			return redirect()->route('configs.first');
		} elseif ($this->auth->user()->connected_at->diffInHours() > 15.4) {
			$this->auth->user()->connected_at = Carbon::now();

			$this->auth->user()->save();
		}

		return $next($request);
	}
}
