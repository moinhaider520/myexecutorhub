<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Total number of users with the role 'customer'
            $totalCustomers = User::role('customer')->count();

            // Number of non-active customers
            $nonActiveCustomer = User::role('customer')->where('status', 'N')->count();

            // Number of active customers
            $activeCustomer = User::role('customer')->where('status', 'A')->count();

            // Retrieve customers with selected fields
            $customers = User::role('customer')
                ->select('id', 'name', 'email', 'address', 'contact_number', 'status')
                ->get();

            // Returning the data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'total_customers' => $totalCustomers,
                    'non_active_customers' => $nonActiveCustomer,
                    'active_customers' => $activeCustomer,
                    'customers' => $customers
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve dashboard data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
