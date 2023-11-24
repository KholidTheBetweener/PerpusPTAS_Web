@extends('layouts.dash')
@section('title', 'Peminjaman Aktif')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Kelola Pinjam</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('rent.create') }}"> Peminjaman Baru</a>
                    <a class="btn btn-primary" href="{{ url('/admin/rent/all')}}"> Catatan Peminjaman</a>
                    <a class="btn btn-warning" href="{{ url('/admin/rent/kembali')}}"> Pengembalian Buku</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'pending' || request('type') == 'null') active @endif" aria-current="page" href="{{route('rent.index', [ 'type' => 'pending' ])}}">Pending</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'renting') active @endif" href="{{route('rent.index', [ 'type' => 'renting' ])}}">Renting</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'overdue') active @endif" href="{{route('rent.index', [ 'type' => 'overdue' ])}}">Overdue</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'finish') active @endif" href="{{route('rent.index', [ 'type' => 'finish' ])}}">Finish</a>
  </li>
</ul>
<!-- Tabs content -->
<div class="tab-content" id="ex1-content">
  <div
    class="tab-pane fade show active"
    id="ex1-tabs-1"
    role="tabpanel"
    aria-labelledby="ex1-tab-1"
  >
  <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>Nama Buku Pinjaman</th>
                    <th>
                    @if(request('type') == 'pending' || request('type') == 'null')
                    Tanggal Pengajuan 
                    @endif
                    @if(request('type') == 'renting') 
                    Tanggal Pinjam
                    @endif    
                    @if(request('type') == 'overdue') 
                    Tanggal Deadline Peminjaman
                    @endif
                    @if(request('type') == 'finish') 
                    Tanggal Pengembalian
                    @endif
                    </th>
                    <th>Status</th>
                    <th width="280px">Aksi</th>
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
                        @if(request('type') == 'pending' || request('type') == 'null')
                        {{ $row->date_request }}
                        @endif
                        @if(request('type') == 'renting') 
                        {{ $row->date_rent }}
                        @endif    
                        @if(request('type') == 'overdue') 
                        {{ $row->date_due }}
                        @endif
                        @if(request('type') == 'finish') 
                        {{ $row->date_finish }}
                        @endif
                        </td>
                        <td>
                        @if(request('type') == 'pending' || request('type') == 'null')
                        Pengajuan Buku
                        @endif
                        @if(request('type') == 'renting') 
                        Sedang dalam peminjaman
                        @endif    
                        @if(request('type') == 'overdue') 
                        Telat mengembalikan Buku
                        @endif
                        @if(request('type') == 'finish') 
                        Selesai meminjam Buku
                        @endif
                        </td>
                        <td>
                        @if(request('type') == 'pending' || request('type') == 'null')
                        <form action="{{ route('pinjam.destroy',$row['id']) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('pinjam.edit',$row['id']) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        @endif
                        @if(request('type') == 'renting') 
                        <form action="{{ route('pinjam.destroy',$row['id']) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('pinjam.edit',$row['id']) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        @endif    
                        @if(request('type') == 'overdue') 
                        <form action="{{ route('pinjam.destroy',$row['id']) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('pinjam.edit',$row['id']) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        @endif
                        @if(request('type') == 'finish') 
                        <form action="{{ route('pinjam.destroy',$row['id']) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('pinjam.edit',$row['id']) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        @endif
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
  </div>
<!-- Tabs content -->
    </div>
@endsection