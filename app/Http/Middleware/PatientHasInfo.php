<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Constants\Rol;
use App\Models\PatientsInfos;
use Closure;
use Illuminate\Http\Request;

class PatientHasInfo
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $patient = PatientsInfos::where('patient_id', $user->id)->first();
        if (!$patient) {
            return response(['message' => 'Must complete the extra information to create a submission.'], 403);
        }

        return $next($request);
    }
}
