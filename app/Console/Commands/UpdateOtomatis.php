<?php

namespace App\Console\Commands;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Console\Command;

class UpdateOtomatis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-otomatis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredDecline = Transaksi::with('detail_transaksi')
            ->where('expired_at', '<=', now())
            ->whereHas('detail_transaksi', function ($query) {
                $query->where('status_konfirm', null);
            })
            ->get();
        // dd($expiredDecline);
        foreach ($expiredDecline as $decline) {
            $status = 'menunggu';
            DetailTransaksi::where('kode_tr', $decline['kode_tr'])->update([
                'status_konfirm' => $status,
            ]);
            // Lakukan tindakan sesuai kebutuhan, contohnya:
            // $payment->delete();
            // atau
            // $payment->update(['status' => 'expired']);
        }
    }
}
