@extends('layouts.dash')
@section('title', 'Catatan Peminjaman')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Kelola Pinjam</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('pinjam.create') }}"> Buat Peminjaman Baru</a>
                    <a class="btn btn-primary" href="{{ route('pinjam.index') }}"> Peminjaman Aktif</a>
                    <a class="btn btn-warning" href="{{ url('/admin/pinjam/kembali')}}"> Pengembalian Buku</a>
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
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Nama Buku Pinjaman</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Tenggat</th>
                    <th>Status</th>
                    <th width="280px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows['data'] as $row)
                    <tr>
                        <td>{{ $row['id'] }}</td>
                        <td>
                        {{ $row['user']['username'] }}
                        </td>
                        <td>
                        {{ $row['buku']['nama_buku'] }}
                        </td>
                        <td>{{ $row['tgl_pinjam'] }}</td>
                        <td>{{ $row['tgl_tenggat'] }}</td>
                        <td>@if($row['status_pengembalian'] == 1)
                            Dalam Peminjaman
                            @else
                            Sudah Dikembalikan
                            @endif                        
                        </td>
                        <td>
                            <form action="{{ route('pinjam.destroy',$row['id']) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('pinjam.edit',$row['id']) }}">Edit</a>
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