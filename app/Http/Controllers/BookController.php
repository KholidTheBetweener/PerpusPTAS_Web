<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\Book;
use App\Models\Rent;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Http\JsonResponse;
use Excel;
use Notification;
use App\Imports\BookImport;
use App\Notifications\NewBookNotification;
use App\Notifications\ImportBookNotification;

class BookController extends Controller
{
    public function search(Request $request): JsonResponse
        {
            $data = [];
    
            if($request->filled('q')){
                $data = Book::select("book_title", "id")
                            ->where('book_title', 'LIKE', '%'. $request->get('q'). '%')
                            ->limit(10)->get();
            }
            return response()->json($data);

        }
        public function import(Request $request)
        {
            // Validate the uploaded file
            $request->validate([
                'file' => 'required|mimes:csv,xls,xlsx',
            ]);
            // Get the uploaded file
            $file = $request->file('file');
            $import = new BookImport;
            // Process the Excel file
            Excel::import($import, $file);
            $users = User::all();
            //how to count in excel?
            //dd($import);
            Notification::send($users, new ImportBookNotification($import->getRowCount));
            return redirect()->route('book.index')->with('success', 'Excel file imported successfully!');
        }
    protected function index()
    {
        $books = Book::orderBy('id')->orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.book.index', compact('books'));
    }
    //buat insert buku banyak lewat excel
    public function create()
    {
        $k = Categories::all();
        $d = $k;
        return view('admin.book.create', compact('k', 'd'));
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
        $book = Book::create($input);
        $users = User::all();
        Notification::send($users, new NewBookNotification($book));
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
    protected function update(Request $request, Book $book)
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
        $book->fill([
            'book_code'     => $input['book_code'],
            'book_title'   => $input['book_title'],
            'author'     => $input['author'],
            'category'     => $input['category'],
            'publisher'     => $input['publisher'],
            'stock'     => $input['stock'],
            'book_cover'     => $input['book_cover'],
            'book_desc'     => $input['book_desc'],
            'barcode'     => $input['barcode'],
        ])->save();
        return redirect()->route('book.index')->with('success','Buku Has Been updated successfully');
    }
    protected function destroy($id)
    {
        //find if rent had book
        $book = Book::with('rent')->findOrFail($id);
        if ($book->rent->count() == 0) {
            $book->delete();
            return redirect()->route('book.index')->with('success','Buku has been deleted successfully');
         }
        else{
            $count = $book->rent->count();
            return redirect()->route('book.index')->with('success','Ada '. $count .' Catatan Peminjaman untuk buku ini dan catatan perlu dihapus dulu sebelum buku bisa dihapus');
        }
    }
}
