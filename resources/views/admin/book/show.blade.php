@extends('layouts.dash')
@section('title', 'Detail Buku')
@section('content')
<script src="{{ asset('js/app.js') }}"></script>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Detail Buku</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('book.index') }}">Kembali Ke Index Buku</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table">
            <tbody>
            <tr>
                    <td>Nama Buku</td>
                    <td>:</td>
                        <td>&ensp; {{ $book->book_title }}</td>
                        <td rowspan="5">
                        @if ($book->book_cover == null)
                        <form action="{{ route('book.cover',$book) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="book_cover" placeholder="Cover Buku" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        @error('book_cover')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                            <br>    
                                <button type="submit" class="btn btn-danger">Upload Foto</button>
                            </form>
                        @endif
                        @isset ($book->book_cover)
                        <img src="/book_cover/{{ $book->book_cover }}" width="200px">
                        @endisset    
                    </td>
                    </tr>
                    <tr>
                    <td>Kode Buku</td>
                    <td>:</td>
                        <td>&ensp; {{ $book->book_code }}</td>
                    </tr>
                    <tr>
                    <td>Penulis</td>
                    <td>:</td>
                        <td>&ensp; {{ $book->author }}</td>
                    </tr>
                    <tr>
                    <td>Penerbit</td>
                    <td>:</td>
                        <td>&ensp; {{ $book->publisher }}</td>
                    </tr>
                    <tr>
                    <td>Kategori</td>
                    <td>:</td>
                        <td>&ensp; {{ $book->category }}</td>
                    </tr>
                    <tr>
                    <td>Stok</td>
                    <td>:</td>
                        <td>&ensp; {{ $book->stock }}</td>
                        <td rowspan="2">
                        @if ($book->barcode == null)
                        <form action="{{ route('book.barcode', $book) }}" method="POST" enctype="multipart/form-data">    
                        @csrf
                        <input type="text" name="barcode" class="form-control" placeholder="Barcode Buku" id="scanner" />
                        @error('barcode')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary ml-3">Submit</button>
                        </form>
                        @endif
                        @isset($book->barcode)
                        {!! DNS1D::getBarcodeHTML($book->barcode, 'EAN13') !!}
                        {{ $book->barcode }}
                        @endisset
                    </td>
                    </tr>
                    <tr>
                    <td>Deskripsi</td>
                    <td>:</td>
                        <td>&ensp; {{ $book->book_desc }}</td>
                    </tr>
            </tbody>
        </table>
    </div>
@endsection