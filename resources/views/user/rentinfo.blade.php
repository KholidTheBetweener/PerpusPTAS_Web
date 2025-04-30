@extends('layouts.app')
@section('title', 'Detail Peminjaman')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Detail Peminjaman</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('rent') }}"> Kembali Ke Riwayat Peminjaman</a>
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
                    <td>Nama Peminjam</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->user->name }}</td>
                        <td rowspan="5">
                        @isset ($pinjam->user->photo)
                        <img src="/{{ $pinjam->user->photo }}" width="150px">
                        @endisset    
                    </td>
                    </tr>
                    <tr>
                    <td>Email</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->user->email }}</td>
                    </tr>
                    <tr>
                    <td>Alamat</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->user->address }}</td>
                    </tr>
                    <tr>
                    <td>Nomer Telepon</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->user->phone }}</td>
                    </tr>
                    <tr>
                    <td>Komponen</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->user->component }}</td>
                    </tr>
                    <tr>
                    <td>Buku Pinjaman</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->book->book_title }}</td>
                        <td rowspan="4">
                        @isset ($pinjam->book->book_cover)
                        <img src="/{{ $pinjam->book->book_cover }}" width="150px">
                        @endisset
                    </tr>
                    <tr>
                    <td>Kategori Buku</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->book->categories->name }}</td>
                    </tr>
                    <td>Tanggal Pengajuan Pinjam</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->date_request }}</td>
                    </tr>
                    </tr>
                    <td>Tanggal Mulai Pinjam</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->date_rent }}</td>
                    </tr>
                    </tr>
                    <td>Tanggal Batas Waktu Pinjam</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->date_due }}</td>
                    </tr>
                    </tr>
                    <td>Tanggal Pengembalian Buku</td>
                    <td>:</td>
                        <td>&ensp; {{ $pinjam->date_return }}</td>
                    </tr>
            </tbody>
        </table>
    </div>
@endsection