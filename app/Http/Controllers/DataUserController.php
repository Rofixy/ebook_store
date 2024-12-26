<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DataUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%');
        }

        // Paginate with 10 rows per page
        $users = $query->paginate(10);

        return view('admin.datauser.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('admin.datauser.create');
    }

    // Store a newly created user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'nik' => 'nullable|string|max:20|unique:users,nik',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('datauser.index')->with('success', 'User created successfully.');
    }

    // Show the form for editing the specified user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.datauser.edit', compact('user'));
    }

    // Update the specified user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'nik' => 'nullable|string|max:20|unique:users,nik,' . $user->id,
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('datauser.index')->with('success', 'User updated successfully.');
    }

    // Delete the specified user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('datauser.index')->with('success', 'User deleted successfully.');
    }
}
