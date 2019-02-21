<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;

class Administrator
{

    protected $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
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
        if (!is_admin()) {
            return redirect()->route('index')->with([
                'class' => 'alert-danger',
                'message' => 'Access Denied!',
            ]);
        }

        return $next($request);
    }
}
