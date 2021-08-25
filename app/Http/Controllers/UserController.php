<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


    public function index(User $model)
    {
        $users = User::with('city')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return $user;
    }

    public function edit(User $user)
    {

        $user_permissions = $user->getDirectPermissions()->pluck(['id'])->toArray();
        $permissions = Permission::all();
        $user_role = $user->getRoleNames()->toArray();

        $roles = Role::with('permissions')->get();

        return view('users.edit', compact('user', 'permissions', 'user_permissions', 'user_role', 'roles'));
    }

    public function userPermissions(User $user, Permission $permission)
    {
        $user_permissions = $user->getDirectPermissions()->pluck(['id'])->toArray();
        if (in_array("$permission->id", $user_permissions)) {
            $user->revokePermissionTo($permission->name);

        } else {
            $user->givePermissionTo($permission->name);

        }
        return redirect()->back();

    }

    public function userRoles(User $user, Role $role)
    {

        $user_roles = $user->getRoleNames()->toArray();

        if (in_array("$role->name", $user_roles)) {
            $user->removeRole($role->name);
        } else {
            $user->assignRole($role->name);

        }
        return redirect()->back();
    }

    public function update(User $user)
    {
        if ($user->activate_at) $user->activate_at = NULL;
        else $user->activate_at = now();
        $user->save();
        return redirect()->back();
    }

    public function updateBalance(User $user, Request $request)
    {

        $admin = User::find(Auth::id());


        $admin->transfer()->create([
            'user_id' => $user->id,
            'before' => $user->balance,
            'after' => $user->balance + $request->balance,
            'points' => 0,
            'key' => NULL,
            'transfer_out' => 0,
            'amount' => $request->balance,
            'created_at' => now(),
        ]);

        $user->transfer()->create([
            'user_id' => $admin->id,
            'before' => $admin->balance,
            'after' => $admin->balance - $request->balance,
            'points' => 0,
            'key' => NULL,
            'amount' => $request->balance,
            'created_at' => now(),
        ]);

        $admin->balance = $admin->balance - $request->balance;
        $admin->save();


        $user->balance = $request->balance + $user->balance;
        $user->save();
        $request->session()->flash('status', 'تمت اضافه الرصيد بنجاح!');
        return response('تمت اضافه الرصيد بنجاح', 200);
    }

    public function search(Request $request)
    {
        if ($request->q) {
            return User::where('phone', 'like', "%$request->q%")->take('10')->get();

        }
    }

    public function changePassword(Request $request, User $user)
    {

        $validation = Validator::make($request->all(),
            [
                'phone' => 'required|exists:users,phone',
                'password' => 'required|confirmed|min:6'
            ], [
                'phone.required' => 'يرجى ادخال رقم الهاتف',
                'phone.exists' => 'رقم الهاتف غير موجود',

                'password.required' => 'يرجى ادخال كلمره السر الجديده',
                'password.confirmed' => 'الباسورد غير مطايق',
                'password.min' => 'يرجى اختيار كلمه سر اكثر من 6 احرف',
            ]
        );

        if ($validation->fails()) {
            $request->session()->flash('error', $validation->errors()->first());
            return redirect()->back()->withInput();
        }

        if ($request->phone != $request->user->phone) {
            $request->session()->flash('error', 'رقم الهاتف غير صحيح ');
            return redirect()->back()->withInput();
        }
        $user->password = \Hash::make($request->password);
        $user->save();

        $request->session()->flash('status', 'تم تغير كلمه السر بنجاح');
        return redirect()->back();

    }

}
