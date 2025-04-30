@extends('layouts.app')
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
                    <a class="btn btn-success" href="{{ route('home') }}">Kembali Ke Index Buku</a>
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
                        <img src="/{{ $book->book_cover }}" width="200px">
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
                        <td>&ensp; {{ $book->categories->name }}</td>
                    </tr>
                    <tr>
                    <td>Stok</td>
                    <td>:</td>
                        <td>&ensp; {{ $book->stock }}</td>
                        <td rowspan="2">
                        
                        {{ $book->barcode }}
                    </td>
                    </tr>
                    <tr>
                    <td>Deskripsi</td>
                    <td>:</td>
                        <td>&ensp; {{ $book->book_desc }}</td>
                    </tr>
            </tbody>
        </table>
        @if ($iscomplete == true)
            @if ($book->stock > 0)
                        <form action="{{ route('requestrent', $book->id) }}" method="POST" enctype="multipart/form-data">    
                        @csrf
                        <button type="submit" class="btn btn-primary ml-3">Mengajukan Peminjaman</button>
                        </form>
            @else
            <a class="btn btn-primary" href="{{ route('home') }}">Maaf, Persediaan Buku Ini Habis. Silahkan Pilih Buku Lain</a>
            @endif
        @else
        <a class="btn btn-primary" href="{{ route('userprofile') }}">Lengkapi data profil</a>
        @endif
    </div>
@endsection