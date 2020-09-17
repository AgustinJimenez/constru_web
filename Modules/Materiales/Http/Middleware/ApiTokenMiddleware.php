<?php namespace Modules\Materiales\Http\Middleware; 

use Closure;

class ApiTokenMiddleware 
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    private $token = "okeJ1R6dO1d78RjiLJcD6wllcRulFQXTpLCdP9gMwnPhYX7WiX6AH2FkezKM";

    public function handle($re, Closure $next)
    {
        if ($re->has('api_token'))
            if($re->get('api_token') == $this->token)
                return $next($re);
            else
                return response()->json(['status' => 'Error 499 invalid token']);
        else
            return response()->json(['status' => 'Error 498 token not found']);
    }

}
