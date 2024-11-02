<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display the customer's unread notifications.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customer = Auth::user();
        // Fetch only unread notifications
        $notifications = $customer->notifications()->whereNull('read_at')->get();

        return view('customer.notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     *
     * @param  int  $notificationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($notificationId)
    {
        $customer = Auth::user();
        
        $notification = $customer->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}
