@extends('layouts.dash')
@section('title', 'Pengembalian Buku')
@section('content')
<script src="{{ asset('js/app.js') }}"></script>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Pencarian Buku</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('rent.index')}}"> Peminjaman Aktif</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ url('/admin/pinjam/track') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Cari Identifikasi Pengguna atau Buku:</strong>
                        <input type="text" name="name" class="form-control" placeholder="Scan Peminjaman Buku Disini" id="scanner" />
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>Nama Buku Pinjaman</th>
                    <th>
                    @if(request('type') == 'pending' || request('type') == null)
                    Tanggal Pengajuan 
                    @endif
                    @if(request('type') == 'renting') 
                    Tanggal Pinjam
                    </th>
                    <th>
                    Batas Pengembalian
                    @endif    
                    @if(request('type') == 'overdue') 
                    Tanggal Deadline Peminjaman
                    @endif
                    @if(request('type') == 'finish') 
                    Tanggal Pengembalian
                    @endif
                    </th>
                    <th>Status</th>
                    <th width="280px" colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($rows->count() > 0)
                @foreach ($rows as $row)
                    <tr>
                        <td>
                        {{ $row->user->name }}
                        </td>
                        <td>
                        {{ $row->book->book_title }}
                        </td>
                        <td>
                        @if(request('type') == 'pending' || request('type') == null)
                        {{ $row->date_request }}
                        @endif
                        @if(request('type') == 'renting') 
                        {{ $row->date_rent }}
                        </td>
                        <td>
                        {{ $row->date_due }}
                        @endif    
                        @if(request('type') == 'overdue') 
                        {{ $row->date_due }}
                        @endif
                        @if(request('type') == 'finish') 
                        {{ $row->date_return }}
                        @endif
                        </td>
                        <td>
                        @if(request('type') == 'pending' || request('type') == null)
                        Mengajukan Peminjaman Buku
                        @endif
                        @if(request('type') == 'renting') 
                        Buku Sedang Dipinjam
                        @endif    
                        @if(request('type') == 'overdue') 
                        Waktu Peminjaman Buku Habis dan Belum Dikembalikan
                        @endif
                        @if(request('type') == 'finish') 
                        Buku Sudah Selesai Dipinjam
                        @endif
                        </td>
                        <td>
                        @if(request('type') == 'pending' || request('type') == null)
                            <form action="{{ route('rent.approve',$row['id']) }}" method="Post">
                                @csrf
                                <button type="submit" class="btn btn-primary show-alert-approve-box" data-toggle="tooltip" title='approve'>Terima</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('rent.destroy',$row['id']) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger show-alert-delete-box" data-toggle="tooltip" title='Delete'>Tolak</button>
                            </form>
                        @endif
                        @if(request('type') == 'renting')
                        <form action="{{ route('rent.return',$row['id']) }}" method="Post">
                        @csrf
                                <button type="submit" class="btn btn-success show-alert-done-box" title='done'>Selesai</button>
                            </form>
                        </td>
                        <td>
                        <form action="{{ route('rent.alert',$row['id']) }}" method="Post">
                        @csrf
                                <button type="submit" class="btn btn-warning show-alert-warning-box" title='warning'>Peringati</button>
                        </form>
                        @endif    
                        @if(request('type') == 'overdue')
                        <form action="{{ route('rent.return',$row['id']) }}" method="Post">
                                @csrf
                                <button type="submit" class="btn btn-success show-alert-done-box" title='done'>Selesai</button>
                            </form>
                        </td>
                        <td>
                        <form action="{{ route('rent.warning',$row['id']) }}" method="Post">
                        @csrf
                                <button type="submit" class="btn btn-danger show-alert-warning-box" title='warning'>Peringatan</button>
                            </form> 
                        @endif
                        @if(request('type') == 'finish') 
                        <form action="{{ route('rent.destroy',$row['id']) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('rent.edit',$row['id']) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger show-alert-delete-box">Hapus</button>
                            </form>
                        @endif
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection