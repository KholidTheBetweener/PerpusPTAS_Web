@extends('layouts.dash')
@section('title', 'Kelola Kategori')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Kelola Kategori</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('categories.create') }}"> Buat Kategori Baru</a>
                    <a class="btn btn-warning" href="{{ route('book.index') }}"> List Buku</a>
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
                    <th>Nama Kategori</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategori as $kategori)
                    <tr>
                        <td>{{ $kategori->name }}</td>
                        <td>
                            <form action="{{ route('categories.destroy',$kategori->id) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('categories.edit',$kategori->id) }}">Edit</a>
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