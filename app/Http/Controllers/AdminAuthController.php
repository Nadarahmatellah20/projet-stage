<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;
use App\Models\Ticket;

class AdminAuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('cp');
        }

        return view('admin.auth.login');
    }

    public function admLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt([
            'email'    => $request->email,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();
            return redirect('cp');
        }

        return back()->withErrors(['login' => 'Login details are not valid']);
    }

    public function controlPanel()
    {
        $admin = Auth::guard('admin')->user();

        $ordersCount  = Order::where('is_archived', false)
                             ->where('is_canceled', false)
                             ->count();

        $usersCount   = User::count();

        $ticketsCount = Ticket::where('status', 'ongoing')
                              ->where('isArchived', false)
                              ->count();

        $latestOrders = Order::with('Client')
                             ->where('is_archived', false)
                             ->where('is_canceled', false)
                             ->latest()
                             ->take(10)
                             ->get();

        return view('admin.control-panel', compact(
            'admin',
            'ordersCount',
            'usersCount',
            'ticketsCount',
            'latestOrders'
        ));
    }

    public function showProfile()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.profile', compact('admin'));
    }

    public function signOut()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('cp/login');
    }
}
