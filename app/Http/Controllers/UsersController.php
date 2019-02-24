<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Library\Hash;
use App\User;
use App\Branch;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::selectRaw('
                user_id, username, email, active, last_login, 
                user.created_at, is_admin, branch_name, department_name
            ')->leftJoin('branch', 'user.branch_id', '=', 'branch.branch_id')
            ->leftJoin('department', 'user.department_id', '=', 'department.department_id')
            ->orderByRaw('username')
            ->paginate(env('PAGE_SIZE', 10));
        
        $data = [
            'title' => 'Users',
            'users' => $users,
        ];

        return view('main/users/index', $data);
    }

    public function create()
    {
        $branches = Branch::selectRaw('branch_id, branch_name')
            ->orderBy('branch_name')
            ->pluck('branch_name', 'branch_id')
            ->toArray();
        
        $data = [
            'title' => 'Add User',
            'branches' => $branches,
        ];

        return view('main/users/create', $data);
    }

    public function store(AddUserRequest $request)
    {
        $salt = Hash::salt();
        $passwd = Hash::make($request->password, $salt);

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->salt = $salt;
        $user->passwd = $passwd;
        $user->branch_id = $request->branch;
        $user->department_id = $request->department;
        $user->is_admin = $request->is_admin ? 1 : 0;
        $user->save();

        return redirect()->route('users')->with([
            'class' => 'alert-success',
            'message' => 'User added successfully',
        ]);
    }

    public function edit($user_id)
    {
        $user = User::findOrFail((int)$user_id);

        $branches = Branch::selectRaw('branch_id, branch_name')
            ->orderBy('branch_name')
            ->pluck('branch_name', 'branch_id')
            ->toArray();
        
        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'branches' => $branches,
        ];

        return view('main/users/edit', $data);
    }

    public function update(EditUserRequest $request, $user_id)
    {
        $user = User::findOrFail((int)$user_id);

        $rules = [];
        if ($user->username != $request->username) {
            $rules['username'] = 'unique:user';
        }
        if ($user->email != $request->email) {
            $rules['email'] = 'unique:user';
        }
        $this->validate($request, $rules, [], [
            'username' => 'Username',
            'email' => 'Email',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->branch_id = $request->branch;
        $user->department_id = $request->department;
        $user->is_admin = $request->is_admin ? 1 : 0;
        $user->save();

        return redirect()->route('users')->with([
            'class' => 'alert-success',
            'message' => 'User edited successfully',
        ]);
    }

    public function delete($user_id)
    {
        $user = User::findOrFail((int)$user_id);
        
        $data = [
            'title' => 'Delete User',
            'user' => $user,
        ];

        return view('main/users/delete', $data);
    }

    public function destroy(Request $request, $user_id)
    {
        if ($request->submit == 'Cancel') {
            return redirect()->route('users');
        }

        $user = User::findOrFail((int) $user_id);

        $flash_message_attributes = [];
        if ($request->submit == 'Delete User') {
            $user->delete();

            $flash_message_attributes = [
                'class' => 'alert-success',
                'message' => 'User deleted successfully',
            ];
        }

        return redirect()->route('users')
            ->with($flash_message_attributes);
    }

    public function changePassword($user_id)
    {
        $user = User::findOrFail($user_id);
        
        $data = [
            'title' => 'Change Password',
            'user' => $user,
        ];

        return view('main/users/change_password', $data);
    }

    public function storePassword(Request $request, $user_id)
    {
        $this->validate($request,
            ['password' => 'required|string|min:8|confirmed'],
            [
                'password.required' => 'Password is required',
                'password.confirmed' => 'Passwords must match',
                'password.min' => 'Password must be a minimum of 8 characters',
            ]
        );

        $salt = Hash::salt();
        $password = Hash::make($request->password, $salt);

        $user = User::findOrFail($user_id);
        $user->salt = $salt;
        $user->passwd = $password;
        $user->save();
        
        $message = 'Password for <em>' . $user->username;
        $message .= '</em> changed successfully';

        return redirect()->route('users')->with([
            'class' => 'alert-success',
            'message' => $message,
        ]);
    }

    public function activate($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->active = true;
        $user->save();

        return redirect()->route('users')->with([
            'class' => 'alert-success',
            'message' => 'User account activated successfully',
        ]);
    }

    public function deactivate($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->active = false;
        $user->save();

        return redirect()->route('users')->with([
            'class' => 'alert-success',
            'message' => 'User account deactivated successfully',
        ]);
    }
}
