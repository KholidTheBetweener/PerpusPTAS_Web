@extends('layouts.dash')
@section('title', 'Kelola Buku')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Kelola Buku</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('book.create') }}"> Masukkan Buku Baru</a>
                    <a class="btn btn-warning" href="{{ route('categories.index') }}"> List Kategori</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Nama Buku</th>
                    <th>Kategori</th>
                    <th>Ketersediaan</th>
                    <th width="280px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($buku as $buku)
                    <tr>
                        <td><img src="/{{ $buku->book_cover }}" width="100px"></td>
                        <td>{{ $buku->book_title }}</td>
                        <td>{{ $buku->categories->name }}</td>
                        <td>{{ $buku->stock }}</td>
                        <td>
                            <form action="{{ route('book.destroy',$buku->id) }}" method="Post">
                            <a class="btn btn-success" href="{{ route('book.show',$buku->id) }}">Detail</a>    
                            <a class="btn btn-warning" href="{{ route('book.edit',$buku->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
@endsection