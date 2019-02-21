<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;

class SessionTimeout
{

    protected $session;
    protected $timeout = 600;

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
        $isLoggedIn = ($request->path() != 'logout');

        if (!session('lastActivityTime')) {
            $this->session->put('lastActivityTime', time());
        } else if (time() - $this->session->get('lastActivityTime') > $this->timeout) {
            $this->session->forget('lastActivityTime');
            
            $user = auth()->user();
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();

            auth()->logout();

            $message = 'Your session timed out after over ';
            $message .= ($this->timeout / 60) . ' minutes of inactivity';

            return redirect()->route('login')->with([
                'class' => 'alert-info',
                'message' => $message,
            ]);
        }

        if ((bool)$isLoggedIn) {
            $this->session->put('lastActivityTime', time());
        } 

        return $next($request);
    }
}
