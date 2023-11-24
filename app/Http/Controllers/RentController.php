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
        $rows = Rent::query()->with(['book', 'user'])->paginate(5)->toArray(); // the rows will be in data key
        return view('admin.rent.all', ['rows' => $rows]);
    }
    protected function kembali()
    {
        return view('admin.rent.kembali');
    }
    protected function track(Request $request)
    {
        $pinjam = Rent::where('book_code','like','%' . request('book_code') . '%')->first();
        $pinjam->status = false;
        $pinjam->save();
        return redirect()->route('rent.index')->with('success','Buku Telah dikembalikan');
    }
    protected function index(Request $request)
    {
        //$rows = Rent::query()->with(['book', 'user'])->paginate(5)->toArray(); // the rows will be in data key
        $query = Rent::query();
        if ($request->type == 'pending') {
            $query = $query->whereNull('status')->whereNotNull('date_request');
        } 
        elseif ($request->type == 'renting'){
            $query = $query->where('status', true)->whereNotNull('date_rent');
        }
        elseif ($request->type == 'overdue'){
            $query = $query->where('date_due', '>', Carbon::now());
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
    public function create()
    {
        $user = User::all();
        $book = Book::all();
        return view('admin.rent.create', compact('user', 'book'));
    }
    protected function store(Request $request)
    {
        $iduser = User::where('email','like','%' . request('email') . '%')->first()->id;
        $idbuku = Book::where('book_title','like','%' . request('book_title') . '%')->first()->id;
        Rent::create([
            'books_id' => $idbuku,
            'users_id' => $iduser,
        ]);
        //$iduser->bukus()->attach($idbuku);
        return redirect()->route('rent.index')->with('success','Pinjam has been created successfully.');
    }
    protected function pinjam($id)
    {
        $pinjam = Rent::find($id);
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
    protected function destroy(Rent $pinjam)
    {
        $pinjam->delete();
        return redirect()->route('rent.index')->with('success','Pinjam has been deleted successfully');
    }
}
