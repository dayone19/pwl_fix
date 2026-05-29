<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Failed; // bawaan laravel (kalau login salah, maka terhitung failed)
use Illuminate\Support\Facades\Event;
use App\Models\Pengguna;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    //untuk ngasih waktu 15 menit kaalu udah gagal login 3x
    public function boot(): void
    {
        Event::listen(Failed::class, function ($event) {
            if ($event->user instanceof Pengguna) {
                $user = $event->user;
                $attempts = $user->login_attempts + 1;

                if ($attempts >= 3) {
                    $user->update([
                        //kalau udah gabisa login 3x, langsung kunci 15 menit
                        'login_attempts' => $attempts,
                        'lockout_time' => Carbon::now('Asia/Jakarta')->addMinutes(15)
                    ]);
                } else {
                    $user->update([
                        //kalau belum 3x increment aja 
                        'login_attempts' => $attempts
                    ]);
                }
            }
        });

        
    }
}
