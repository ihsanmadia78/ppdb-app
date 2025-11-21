<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftar;
use App\Mail\PaymentReminder;
use Mail;
use Carbon\Carbon;

class SendPaymentReminders extends Command
{
    protected $signature = 'ppdb:send-payment-reminders';
    protected $description = 'Send payment reminder emails to students with pending payments';

    public function handle()
    {
        $this->info('Sending payment reminders...');
        
        // Ambil pendaftar yang statusnya MENUNGGU_PEMBAYARAN dan sudah lebih dari 2 hari
        $pendaftar = Pendaftar::where('status', 'MENUNGGU_PEMBAYARAN')
            ->where('updated_at', '<=', Carbon::now()->subDays(2))
            ->whereNotNull('email')
            ->get();
        
        $sent = 0;
        $failed = 0;
        
        foreach ($pendaftar as $p) {
            try {
                Mail::to($p->email)->send(new PaymentReminder($p));
                $sent++;
                $this->line("✓ Sent to: {$p->email} ({$p->no_pendaftaran})");
            } catch (\Exception $e) {
                $failed++;
                $this->error("✗ Failed to send to: {$p->email} - {$e->getMessage()}");
            }
        }
        
        $this->info("Payment reminders sent: {$sent} successful, {$failed} failed");
        
        return 0;
    }
}