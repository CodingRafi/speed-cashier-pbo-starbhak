<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class AuthenticationApi
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
        $token = $request->header('Authorization');

        if ($token) {
            $token = explode(' ', $token)[1];
    
            $user = User::where('api_token', $token)->first();
    
            if($user){
                if(Carbon::now() < $user->api_created_at){
                    return $next($request);
                }else{
                    $user->api_token = null;
                    $user->api_created_at = null;
                    $user->save();
    
                    return response()->json([
                        'message' => 'Token sudah expire'
                    ], 401);
                }
            }else{
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }
        }else{
            return response()->json([
                'message' => 'Tidak ada token'
            ], 401);
        }
    }
}
