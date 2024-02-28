<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Book;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function search(Request $request): JsonResponse
        {
            $data = [];
    
            if($request->filled('q')){
                $data = User::where('name', 'LIKE', '%'. $request->get('q'). '%')
                            ->orWhere('email', 'LIKE', '%'. $request->get('q'). '%')
                            ->limit(10)->get()->append('name_email');
            }
         
            return response()->json($data);
        }
    protected function index()
    {
        $users = User::orderBy('id')->orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.user.index', compact('users'));
    }
    public function create()
    {
        return view('admin.user.create');
    }
    protected function store(Request $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        event(new Registered($user));
        return redirect()->route('user.index')->with('success','User has been created successfully.');

    }
    protected function photo(Request $request, User $user)
    {
        $request->validate([
            'photo' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($photo = $request->file('photo')) {
            $destinationPath = 'photo/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $user->photo = "photo/".$profileImage;
        }
        $user->save();
        return redirect()->route('user.show', $user->id)->with('success','User photo has been uploaded.');

    }
    protected function show($id)
    {
        $user = User::find($id);
        return view('admin.user.show',compact('user'));
    }
    public function edit(User $user)
    {
        return view('admin.user.edit',compact('user'));
    }
    protected function update(Request $data, User $user)
    {
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birth_place' => $data['birth_place'],
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'component' => $data['component'],
        ])->save();
        return redirect()->route('user.index')->with('success','User Has Been updated successfully');
    }
    protected function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success','User has been deleted successfully');
    }
}
