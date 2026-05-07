<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if($request->search)
        {
            $request->flash();
            $searching = true;
            $admins = Admin::where('fname', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('lname', 'LIKE', '%' . $request->search . '%')
                            ->paginate(15);
            if($admins->isNotEmpty()){
                $isFound = true;
                return view('admin.account.admin.index', compact('searching', 'isFound', 'admins'));
            }else{
                $isFound = false;
                return view('admin.account.admin.index', compact('searching','isFound'));
            }
        }else{
            $searching = false;
            $admins = Admin::paginate(15);
            return view('admin.account.admin.index', compact('searching', 'admins'));    
        }
    }

    // NOTE: controlPanel() موجودة فـ AdminAuthController — ما كنزيدوهاش هنا

    public function edit(Admin $admin)
    {   
        return view('admin.account.admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        // FIX: validation complète — les champs optionnels marqués nullable
        $validated = $request->validate([
            'fname'   => 'required|string|max:255',
            'lname'   => 'required|string|max:255',
            'email'   => 'required|email|unique:admins,email,' . $admin->id,
            'company' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city'    => 'nullable|string|max:255',
            'zip'     => 'nullable|numeric',
            
            'phone'   => 'nullable|string|max:255',
        ]);

        $admin->fill($validated);
        $admin->save();

        return redirect(route('admins.index'));
    }

    public function show(Admin $admin)
    {
        return view('admin.account.admin.show', compact('admin'));
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect(route('admins.index'));
    }

    public function create()
    {
        return view('admin.account.admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname'    => 'required|string|max:255',
            'lname'    => 'required|string|max:255',
            'authname' => 'required|string|max:255|unique:admins,authname',
            'role'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Admin::create([
            'fname'    => $validated['fname'],
            'lname'    => $validated['lname'],
            'authname' => $validated['authname'],
            'role'     => $validated['role'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect(route('admins.index'));
    }
}
