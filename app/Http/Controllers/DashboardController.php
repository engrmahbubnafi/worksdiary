<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        // $role = User::join('roles', 'users.role_id', 'roles.id')
        //     ->select('roles.name')
        //     ->where('roles.id', $user->role_id)
        //     ->get('name');

        // dump($user->name);
        // dd($role);

        //dd($tokenObj=$user->createToken($request->device_name););
        return view('dashboard.index');
    }
}
