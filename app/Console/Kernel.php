<?php

namespace App\Console;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $expiredPayments = Transaksi::where('expired_at', '<=', now())->get();
            foreach ($expiredPayments as $payment) {

                DetailTransaksi::where('kode_tr', $payment['kode_tr'])->update([
                    'status_konfirm' => 'menunggu',
                ]);
                // if (sizeof($payment) != 0) {

                // }
                // Lakukan tindakan sesuai kebutuhan, contohnya:
                // $payment->delete();
                // atau
                // $payment->update(['status' => 'expired']);
            }
        })->everyTwoSeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
