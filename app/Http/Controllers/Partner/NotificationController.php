<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display the partner's unread notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated partner user
        $partner = Auth::user();
        
        // Retrieve only unread notifications for the authenticated partner
        $notifications = $partner->notifications()->whereNull('read_at')->get();

        return view('partner.notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     *
     * @param  int  $notificationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($notificationId)
    {
        $partner = Auth::user();
        
        $notification = $partner->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}
