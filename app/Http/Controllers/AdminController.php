<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Admin;
use App\Models\Book;
use App\Models\Rent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected function index()
    {
        $admins = Admin::orderBy('id')->orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.admin.index', compact('admins'));
    }
    public function create()
    {
        return view('admin.admin.create');
    }
    protected function store(Request $request)
    {
        $admin = Admin::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->route('admin.index')->with('success','Admin has been created successfully.');
    }
    /*protected function admin($id)
    {
        $user = User::find($id);
    }*/
    public function edit(Admin $admin)
    {
        return view('admin.admin.edit',compact('admin'));
    }
    protected function update(Request $request, Admin $admin)
    {
        $admin->fill([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ])->save();
        return redirect()->route('admin.index')->with('success','Admin Has Been updated successfully');
    }
    protected function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.index')->with('success','Admin has been deleted successfully');
    }
    /*public function showAdminRegisterForm()
    {
        return view('auth.register', ['route' => route('admin.register-view'), 'title'=>'Admin']);
    }*/
}
