<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hardware;
use App\Models\Software;
use App\Models\Course;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontendController extends Controller
{
   
    public function index()
    {
        $servicesList = Service::with('prod_images')->get();
        return view('landing', compact('servicesList'));
    }


    public function searchProduct(Request $request)
    {
        $isFound = false;

        if ($request->search) {
            $isFound = true;

            $hwProductsList = Hardware::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('header', 'LIKE', '%' . $request->search . '%')
                ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                ->get();

            $swProductsList = Software::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('header', 'LIKE', '%' . $request->search . '%')
                ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                ->get();

            $crProductsList = Course::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('header', 'LIKE', '%' . $request->search . '%')
                ->orWhere('category', 'LIKE', '%' . $request->search . '%')
                ->orWhere('prof', 'LIKE', '%' . $request->search . '%')
                ->get();

            $svProductsList = Service::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('header', 'LIKE', '%' . $request->search . '%')
                ->get();

            return view('search', compact(
                'isFound',
                'hwProductsList',
                'swProductsList',
                'crProductsList',
                'svProductsList'
            ));
        }

        return redirect('/')->with('message', 'error');
    }

     
    public function showDashboard()
    {
        return view('user.user-dashboard');
    }

 
    public function accountSettings()
    {
        $user = Auth::user();
        return view('user.dashboard.account', compact('user'));
    }

 
    public function updateUserEmail(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('userAccountSettings')
            ->with('success', 'Email updated successfully');
    }


    public function updateUserPassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'old_password' => 'required|string|max:255',
            'new_password' => 'required|string|min:6|max:255',
        ]);

        if (Hash::check($validated['old_password'], $user->password)) {
            $user->password = Hash::make($validated['new_password']);
            $user->save();

            return redirect()->route('userAccountSettings')
                ->with('success', 'Password updated successfully');
        }

        return redirect()->route('userAccountSettings')
            ->withErrors('Incorrect password');
    }

    public function updateUserInfo(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|numeric',
            'adress' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('userAccountSettings')
            ->with('success', 'Information updated successfully');
    }
}