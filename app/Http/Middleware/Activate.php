<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Carbon\Carbon;

class Activate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //return dd($this->auth->user()->isActive());
        if (!$this->auth->user()->isActive()) {
            return response('Ton compte est désactivé. Un message à été envoyé aux DDP\'s et tu seras contacté par mail lorsque ton compte aura été ré-activé.');
        }

        // Première connexion
        if ($this->auth->user()->isFirstConnection()) {
            return redirect()->route('configs.first');
        } elseif ($this->auth->user()->connected_at->diffInHours() > 15.4) {
            $this->auth->user()->connected_at = Carbon::now();

            $this->auth->user()->save();
        }

        return $next($request);
    }
}
