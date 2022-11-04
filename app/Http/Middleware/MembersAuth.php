<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Crypt;

class MembersAuth
{
    public function handle($request, Closure $next)
    {
        if(isset($_COOKIE['UserStatus'])) {
            if(Crypt::decryptString($_COOKIE['UserStatus']) == '1') {
                return redirect('/member');
            }
            // if($_COOKIE['UserStatus'] == '0') {
            //     return redirect('/');
            // }
        } else {
            // nothing...
        }
 
        return $next($request);
    }
}
