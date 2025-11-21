<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Pendaftar;
use Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = Auth::user();
        $notifications = [];
        
        // Get stored notifications
        $storedNotifications = Notification::where(function($query) use ($user) {
            $query->where('user_role', $user->role)
                  ->orWhere('user_id', $user->id);
        })
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
        
        // Add real-time notifications based on role
        if ($user->role == 'admin') {
            // Pendaftar menunggu verifikasi
            $pending = Pendaftar::where('status', 'SUBMIT')->count();
            if ($pending > 0) {
                $notifications[] = [
                    'id' => 'pending_' . time(),
                    'title' => 'Menunggu Verifikasi',
                    'message' => "{$pending} pendaftar menunggu verifikasi administrasi",
                    'created_at' => now(),
                    'read_at' => null,
                    'type' => 'warning'
                ];
            }
            
            // Pendaftar baru hari ini
            $newToday = Pendaftar::whereDate('created_at', today())->count();
            if ($newToday > 0) {
                $notifications[] = [
                    'id' => 'new_' . time(),
                    'title' => 'Pendaftar Baru',
                    'message' => "{$newToday} pendaftar baru mendaftar hari ini",
                    'created_at' => now(),
                    'read_at' => null,
                    'type' => 'info'
                ];
            }
        }
        
        if ($user->role == 'keuangan') {
            // Pembayaran menunggu verifikasi
            $pendingPayments = \App\Models\Pembayaran::where('status', 'paid')->count();
            if ($pendingPayments > 0) {
                $notifications[] = [
                    'id' => 'payment_' . time(),
                    'title' => 'Pembayaran Menunggu',
                    'message' => "{$pendingPayments} pembayaran menunggu verifikasi",
                    'created_at' => now(),
                    'read_at' => null,
                    'type' => 'warning'
                ];
            }
        }
        
        if ($user->role == 'verifikator') {
            // Berkas menunggu verifikasi
            $pendingDocs = Pendaftar::where('status', 'SUBMIT')->count();
            if ($pendingDocs > 0) {
                $notifications[] = [
                    'id' => 'docs_' . time(),
                    'title' => 'Berkas Menunggu',
                    'message' => "{$pendingDocs} berkas menunggu verifikasi",
                    'created_at' => now(),
                    'read_at' => null,
                    'type' => 'warning'
                ];
            }
        }
        
        // Merge stored and real-time notifications
        $allNotifications = collect($notifications)->merge($storedNotifications);
        $unreadCount = $allNotifications->where('read_at', null)->count();
        
        return response()->json([
            'notifications' => $allNotifications->take(15),
            'unread_count' => $unreadCount
        ]);
    }
    
    public function markAsRead(Request $request)
    {
        $notification = Notification::find($request->notification_id);
        if ($notification) {
            $notification->markAsRead();
        }
        
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        Notification::where(function($query) use ($user) {
            $query->where('user_role', $user->role)
                  ->orWhere('user_id', $user->id);
        })
        ->whereNull('read_at')
        ->update(['read_at' => now()]);
        
        return response()->json(['success' => true]);
    }
}