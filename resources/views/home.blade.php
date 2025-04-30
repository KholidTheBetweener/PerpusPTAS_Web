@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Buku Perpustakaan</h2>
                </div>
            </div>
            <ul class="nav nav-tabs">
            <li class="nav-item">
            <a class="nav-link @if(request('type') == null) active @endif" aria-current="page" href="{{route('home')}}">Semua</a>
            </li> 
            <li class="nav-item">
            <a class="nav-link @if(request('type') == 'tersedia') active @endif" href="{{route('home', [ 'type' => 'tersedia' ])}}">Tersedia</a>
            </li>           
            <li class="nav-item">
            <a class="nav-link @if(request('type') == 'habis') active @endif" href="{{route('home', [ 'type' => 'habis' ])}}">Habis</a>
            </li>
            <li>    
            <form action="{{ route('search') }}" method="GET" enctype="multipart/form-data">
            @csrf
                        <input type="text" class="form-control" id="name" name="name" placeholder="Judul Buku/Kategori/Identifikasi" />
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        </li>
                        <li>
                        <button type="submit" class="btn btn-primary ml-3">Cari</button>
                        </li>
            </form>
            </ul>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Nama Buku</th>
                    <th>Kategori</th>
                    <th>Ketersediaan</th>
                    <th width="280px">Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $buku)
                    <tr>
                        <td><img src="/{{ $buku->book_cover }}" width="100px"></td>
                        <td>{{ $buku->book_title }}</td>
                        <td>{{ $buku->categories->name }}</td>
                        <td>{{ $buku->stock }}</td>
                        <td>
                            <a class="btn btn-success" href="{{ route('detail',$buku->id) }}">Detail</a>    
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        {{ $books->links() }}
    </div>
</div>
@endsection
