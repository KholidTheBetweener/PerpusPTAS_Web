<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NotificationController;
use App\Models\Admin;
use App\Models\User;
use App\Models\Categories;
use App\Models\Book;
use App\Models\Rent;
use Carbon\Carbon;
use App\Events\NewRentNotify;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Book::query();
        if ($request->type == 'tersedia') {
            $query = $query->where('stock', '>', 0);
        }
        elseif ($request->type == 'habis') {
            $query = $query->where('stock', '<=', 0);
        } 
        $books = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('home', compact('books'));
    }
    protected function show($id)
    {
        $user = \Auth::user();
        $arraynull = [];
        if (!$user->name) {
            $arraynull[] = "Nama";
        }
        if (!$user->email) {
            $arraynull[] = "Email";
        }
        if (!$user->birth_place) {
            $arraynull[] = "Tempat Lahir";
        }
        if (!$user->birth_date) {
            $arraynull[] = "Tanggal Lahir";
        }
        if (!$user->phone) {
            $arraynull[] = "Nomer Telepon";
        }
        if (!$user->address) {
            $arraynull[] = "Alamat";
        }
        if (!$user->component) {
            $arraynull[] = "Komponen";
        }
        if (!empty($arraynull)) {
            $iscomplete = false;
        }
        else {
            $iscomplete = true;
        }
        $book = Book::find($id);
        return view('user.detail',compact('book', 'iscomplete'));
    }
    public function search(Request $request)
    {
        //$rents = Rent::paginate(5); // Table-1
        //$books = Book::all();   // Table-2
        //$users = User::all(); 
        //$query = $request->name;
        $query = Book::query()
        ->join('categories', 'books.category', '=', 'categories.id')
        ->where(function($query) use ($request) {
            $query->where('books.book_code','like',"%{$request->name}%")
            ->orWhere('books.book_title','like',"%{$request->name}%")
            ->orWhere('books.barcode','like',"%{$request->name}%")
            ->orWhere('categories.name','like',"%{$request->name}%");
        })->orderBy('books.created_at', 'desc')
        ->paginate(10);
        $books = $query;
        return view('home', compact('books'));
    }
    public function profile(Request $request)
    {
        $user = \Auth::user();
        return view('user.profile',compact('user'));
    }
    protected function update(Request $request)
    {
        $user = \Auth::user();
        $request->validate([
            'name' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'component' => 'required',
            'photo' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = $request->all();
        if ($photo = $request->file('photo')) {
            $destinationPath = 'photo/';
            $profileImage = date('YmdHis') . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $profileImage);
            $data['photo'] = "photo/".$profileImage;
        }
        $user->fill([
            'photo'     => $data['photo'],
            'name' => $data['name'],
            'birth_place' => $data['birth_place'],
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'component' => $data['component'],
        ])->save();
        return redirect()->route('userprofile')->with('success','User Has Been updated successfully');
    }
    protected function emailpassword(Request $data)
    {
        $user = \Auth::user();
        $user->fill([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            
        ])->save();
        return redirect()->route('userprofile')->with('success','User Has Been updated successfully');
    }
    public function notifications(Request $request)
    {
        $notifications = Auth::user()->unreadNotifications;
        return view('user.notification', compact('notifications'));
    }
    public function marknotify($id)
    {
        $user = \Auth::user();
        $notification = $user->notifications->where('id', $id)->first();
        //dd($notification);
        if ($notification) {
            $notification->markAsRead();
        return redirect()->route('notifications')->with('success','Notifikasi Sudah Terbaca');
        }
    }
    public function marknotifyall(Request $request)
    {
        $user = \Auth::user();
        $notification = $user->unreadNotifications;
        if ($notification) {
            $notification->markAsRead();
        return redirect()->route('admin.dashboard')->with('success','Notifikasi Sudah Terbaca');
        }
    }
    public function rent(Request $request)
    {
        $user = \Auth::user();
        $query = Rent::query()->where('users_id',$user->id);
        if ($request->type == 'pending') {
            $query = $query->whereNull('status')->whereNotNull('date_request');
        } 
        elseif ($request->type == 'renting'){
            $query = $query->where('status', true)->whereNotNull('date_rent')->where('date_due', '>', Carbon::now());
        }
        elseif ($request->type == 'overdue'){
            $query = $query->where('status', true)->where('date_due', '<', Carbon::now());
        }
        elseif ($request->type == 'finish'){
            $query = $query->where('status', false)->whereNotNull('date_return');
        }
        else
        {
            $query = $query->whereNull('status')->whereNotNull('date_request');
        }
        $rows = $query->orderBy('updated_at', 'desc')->paginate(10);
        return view('user.rent', ['rows' => $rows]);
    }
    protected function rentinfo($id)
    {
        $pinjam = Rent::find($id);
        return view('user.rentinfo',compact('pinjam'));
    }
    protected function store($id)
    {
        //select2
        $iduser = \Auth::user();
        $idbuku = Book::find($id);
        $rent = Rent::create([
            'books_id' => $idbuku->id,
            'users_id' => $iduser->id,
        ]);
        event(new NewRentNotify($rent));
        //$iduser->bukus()->attach($idbuku);
        return redirect()->route('rent')->with('success','Pinjam has been created successfully.');
    }
    public function dashboard()
    {
        $admin = Admin::count();
        $user = User::count();
        $book = Book::count();
        $apply = Rent::whereNull('status')->whereNotNull('date_request')->count();
        $rent = Rent::where('status', true)->whereNotNull('date_rent')->count();
        $due = Rent::where('date_due', '<', Carbon::now())->where('status', true)->count();
        //gak bisa lihat notif admin
        $notifications = Auth::guard('admin')->user()->unreadNotifications;
        return view('admin', compact('admin', 'user', 'book', 'apply', 'rent', 'due', 'notifications'));
    }
    public function markNotification($id)
    {
        $user = \Auth::guard('admin')->user();
        $notification = $user->notifications->where('id', $id)->first();
        //dd($notification);
        if ($notification) {
            $notification->markAsRead();
        return redirect()->route('admin.dashboard')->with('success','Notifikasi Sudah Terbaca');
        }
    }
    public function markAll(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $notification = $user->unreadNotifications;
        if ($notification) {
            $notification->markAsRead();
        return redirect()->route('admin.dashboard')->with('success','Notifikasi Sudah Terbaca');
        }
    }
}
