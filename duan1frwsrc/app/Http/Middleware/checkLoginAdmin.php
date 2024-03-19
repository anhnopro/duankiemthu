<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Cookie;

use App\Models\admin\UserModel;

class checkLoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($this->isAdmin()) {

            return $next($request);
        } else {
            $urlIndex = route('home');
            return redirect($urlIndex);
        }
    }

    public function filedAdmin() {
        return ['Admin','Subadmin'];
    }

    private function isAdmin() {
        if(Cookie::has('infoLog')) {
            $dataLog = json_decode(Cookie::get('infoLog'),true);
            if(in_array($dataLog['vaiTro'], $this->filedAdmin())) {

                return true;
            }
        }
        return false;
        
    }
}
