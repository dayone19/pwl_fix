<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Pengguna;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

//ini untuk cek masih ada sisa waktu 15 menir atau ga dari provider nya
class CheckLoginLockout
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $nip = $request->input('nip');

        if ($nip) {
            $user = Pengguna::where('nip', $nip)->first();

            if ($user && $user->lockout_time !== null) {
                $now = Carbon::now('Asia/Jakarta');
                $lockoutEnd = Carbon::parse($user->lockout_time, 'Asia/Jakarta');

                if ($now->lessThan($lockoutEnd)) {
                    $remaindMins = $now->diffInMinutes($lockoutEnd, false);

                    return back()->withErrors([
                        'nip' => "Akun Anda dikunci karena 3x salah passwod. Silahkan tunggu {$remaindMins} menit lagi."
                    ])->withInput();
                } else {
                    $user->update([
                        'login_attempts' => 0,
                        'lockout_time' => null
                    ]);
                }
            }
        }
        return $next($request);
    }
}
