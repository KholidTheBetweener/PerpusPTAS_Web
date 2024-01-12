<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Admin;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

class RentController extends Controller
{
    protected function all()
    {
        $rows = Rent::query()->paginate(5)->toArray(); // the rows will be in data key
        $now = Carbon::now();
        return view('admin.rent.all', compact('rows', 'now'));
    }
    protected function search()
    {
        return view('admin.rent.search');
    }
    protected function track(Request $request)
    {
        $pinjam = Rent::where('book_code','like','%' . request('book_code') . '%')->first();
        $pinjam->save();
        return redirect()->route('rent.index')->with('success','Peminjaman Telah ditemukan');
    }
    protected function approve(Request $request, Rent $rent)
    {
        //buku dipinjam kurang 1
        $rent->date_rent = Carbon::now();
        $rent->date_due = Carbon::now()->addWeeks(2);
        $rent->status = true;
        $rent->save();
        return redirect()->route('rent.index')->with('success','Peminjaman telah disetjui');
    }
    protected function return(Request $request, Rent $rent)
    {
        //buku dikembalikan tambah 1
        $rent->date_return = Carbon::now();
        $rent->status = false;
        $rent->save();
        return redirect()->route('rent.index')->with('success','Buku Telah dikembalikan');
    }
    protected function alert(Request $request, Rent $rent)
    {
        //notify->rentoverdue
        return redirect()->route('rent.index')->with('success','Peringatan telat pengembalian telah dikirim');
    }
    protected function warning(Request $request, Rent $rent)
    {
        //notify->rentoverdue
        return redirect()->route('rent.index')->with('success','Peringatan telat pengembalian telah dikirim');
    }
    protected function index(Request $request)
    {
        //$rows = Rent::query()->with(['book', 'user'])->paginate(5)->toArray(); // the rows will be in data key
        $query = Rent::query();
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
        $rows = $query->orderBy('updated_at', 'desc')->paginate(5);
        //dd($rows);
        return view('admin.rent.index', ['rows' => $rows]);
    }
    
    protected function show($id)
    {
        $pinjam = Rent::find($id);
        return view('admin.rent.show',compact('pinjam'));
    }
    public function create()
    {
        $user = User::all();
        $book = Book::all();
        return view('admin.rent.create', compact('user', 'book'));
    }
    protected function store(Request $request)
    {
        //select2
        $iduser = User::where('email','like','%' . request('name') . '%')->first()->id;
        $idbuku = Book::where('book_title','like','%' . request('book_title') . '%')->first()->id;
        Rent::create([
            'books_id' => $idbuku,
            'users_id' => $iduser,
        ]);
        //$iduser->bukus()->attach($idbuku);
        return redirect()->route('rent.index')->with('success','Pinjam has been created successfully.');
    }
    public function edit(Rent $pinjam)
    {
        return view('admin.rent.edit',compact('pinjam'));
    }
    protected function update(Request $request, Rent $pinjam)
    {
        $iduser = User::where('email','like','%' . request('email') . '%')->first()->id;
        $idbuku = Book::where('book_title','like','%' . request('book_title') . '%')->first()->id;
        $request->validate([
            'books_id' => $idbuku,
            'users_id' => $iduser,
            'date_request' => $request['date_request'],
            'date_rent' => $request['date_rent'],
            'status' => $request['status'],
        ]);
        //$iduser->bukus()->detach();
        //$iduser->bukus()->attach($idbuku);
        $pinjam->fill($request->post())->save();
        return redirect()->route('rent.index')->with('success','Pinjam Has Been updated successfully');
    }
    protected function destroy($id)
    {
        $rent = Rent::find($id);
        $success = $rent->delete();
        if($success)
            return redirect()->route('rent.index')->with('success','Pinjam has been deleted successfully');
        else
            return redirect()->route('rent.index')->with('success','Pinjam has fail to delete');
    }
}
