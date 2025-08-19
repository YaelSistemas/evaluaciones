<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('search',''));
        $users = User::query()
            ->when($q, fn($qq)=>$qq->where(fn($w)=>$w
                ->where('name','like',"%$q%")
                ->orWhere('email','like',"%$q%")
            ))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users','q'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
            'is_admin' => ['nullable','boolean'],
        ]);

        User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'is_admin'  => (bool)($data['is_admin'] ?? false),
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('ok','Usuario creado');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','string','min:8','confirmed'],
            'is_admin' => ['required','boolean'],
            'is_active'=> ['required','boolean'],
        ]);

        $user->fill([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'is_admin'  => $data['is_admin'],
            'is_active' => $data['is_active'],
        ]);
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('ok','Usuario actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete(); // soft delete
        return back()->with('ok','Usuario eliminado');
    }

    public function toggle(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return back()->with('ok', $user->is_active ? 'Usuario habilitado' : 'Usuario inhabilitado');
    }
}
