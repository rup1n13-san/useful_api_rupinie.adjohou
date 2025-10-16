<?php

namespace App\Http\Middleware;

use App\Models\Module;
use App\Models\Usermodule;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $id): Response
    {
        $user = $request->user();
        $module = Module::find($id);

        $userModule = Usermodule::where('user_id', $user->id)
                    ->where('module_id', $module->id);
        
        if($userModule->active === false){
            return response()->json([
                "error" => "Module inactive. Please activate this module to use it."
            ],403);
        }
        
        return $next($request);
    }
}