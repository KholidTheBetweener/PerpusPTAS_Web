<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Book;
use App\Models\Rent;
use App\Models\Categories;

class BookController extends Controller
{
    protected function index()
    {
        $buku = Book::orderBy('id')->orderBy('updated_at', 'desc')->paginate(5);
        return view('admin.book.index', compact('buku'));
    }
    //buat insert buku banyak lewat excel
    public function create()
    {
        $k = Categories::all();
        return view('admin.book.create', compact('k'));
    }
    protected function store(Request $request)
    {
        $request->validate([
            'book_code' => 'required',
            'book_title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'publisher' => 'required',
            'stock' => 'required',
            'book_cover' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'book_desc' => 'required',
        ]);
        $input = $request->all();
        if ($bookCover = $request->file('book_cover')) {
            $destinationPath = 'book_cover/';
            $profileImage = date('YmdHis') . "." . $bookCover->getClientOriginalExtension();
            $bookCover->move($destinationPath, $profileImage);
            $input['book_cover'] = "book_cover/".$profileImage;
        }
        Book::create($input);

        return redirect()->route('book.index')->with('success','Buku has been created successfully.');
    }
    protected function show($id)
    {
        $book = Book::find($id);
        return view('admin.book.show',compact('book'));
    }
    public function edit(Book $book)
    {
        $k = Categories::all();
        return view('admin.book.edit',compact('book', 'k'));
    }
    protected function cover(Request $request, Book $book)
    {
        //path file name folder/profileimage
        $request->validate([
            'book_cover' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($book_cover = $request->file('book_cover')) {
            $destinationPath = 'book_cover/';
            $profileImage = date('YmdHis') . "." . $book_cover->getClientOriginalExtension();
            $book_cover->move($destinationPath, $profileImage);
            $book->book_cover = "book_cover/".$profileImage;
        }
        $book->save();
        return redirect()->route('book.show', $book->id)->with('success','Book cover has been uploaded.');
    }
    protected function barcode(Request $request, Book $book)
    {
        $request->validate([
            'barcode' => 'required',
        ]);
        $book->barcode = $request->barcode;
        $book->save();
        return redirect()->route('book.show', $book->id)->with('success','Buku Has Been updated successfully');
    }
    protected function update(Request $request, Book $buku)
    {
        $request->validate([
            'book_code' => 'required',
            'book_title' => 'required',
            'author' => 'required',
            'category' => 'required',
            'publisher' => 'required',
            'stock' => 'required',
            'book_cover' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'book_desc' => 'required',
        ]);
        $input = $request->all();
        if ($bookCover = $request->file('book_cover')) {
            $destinationPath = 'book_cover/';
            $profileImage = date('YmdHis') . "." . $bookCover->getClientOriginalExtension();
            $bookCover->move($destinationPath, $profileImage);
            $input['book_cover'] = "book_cover/".$profileImage;
        }
        $buku->fill($input->post())->save();
        return redirect()->route('book.index')->with('success','Buku Has Been updated successfully');
    }
    protected function destroy(Book $buku)
    {
        $buku->delete();
        return redirect()->route('book.index')->with('success','Buku has been deleted successfully');
    }
}
