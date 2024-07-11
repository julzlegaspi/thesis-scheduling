<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentRoleHasCourseAndSection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (is_null($user->course_id) && is_null($user->section_id) && $user->roles()->pluck('name')[0] === 'student') {
                return redirect()->route('complete.profile.index');
            }
        }

        return $next($request);
    }
}
