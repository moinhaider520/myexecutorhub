<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Total number of users with the role 'customer'
        $totalCustomers = User::role('customer')->count();
        // Number of non active customers 
        $nonActiveCustomer = User::role('customer')->where('status', 'N')->count();
        // Number of active customers 
        $ActiveCustomer = User::role('customer')->where('status', 'A')->count();

        $customers = User::role('customer')
            ->select('id', 'name', 'email', 'address', 'contact_number', 'status','created_at','subscribed_package','trial_ends_at')
            ->get();

        // Subscription Plan Counts
        $basicPlanCount = User::role('customer')
            ->where('subscribed_package', 5.99)
            ->whereNotNull('subscribed_package')
            ->count();

        $standardPlanCount = User::role('customer')
            ->where('subscribed_package', 11.99)
            ->whereNotNull('subscribed_package')
            ->count();

        $premiumPlanCount = User::role('customer')
            ->where('subscribed_package', 19.99)
            ->whereNotNull('subscribed_package')
            ->count();

        // Calculate Total Revenue
        $totalRevenue = ($basicPlanCount * 5.99) + ($standardPlanCount * 11.99) + ($premiumPlanCount * 19.99);



        return view('admin.dashboard', compact(
            'totalCustomers',
            'nonActiveCustomer',
            'ActiveCustomer',
            'customers',
            'totalRevenue'
        ));
    }
}
