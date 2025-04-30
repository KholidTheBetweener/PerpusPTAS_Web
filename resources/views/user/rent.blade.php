@extends('layouts.app')
@section('title', 'Riwayat Peminjaman')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Riwayat Peminjaman</h2>
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
    <a class="nav-link @if(request('type') == 'pending' || request('type') == null) active @endif" aria-current="page" href="{{route('rent', [ 'type' => 'pending' ])}}">Pengajuan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'renting') active @endif" href="{{route('rent', [ 'type' => 'renting' ])}}">Peminjaman</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'overdue') active @endif" href="{{route('rent', [ 'type' => 'overdue' ])}}">Telat</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'finish') active @endif" href="{{route('rent', [ 'type' => 'finish' ])}}">Dikembalikan</a>
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
                    @if(request('type') == 'pending' || request('type') == null)
                    Tanggal Pengajuan 
                    </th>
                    <th>
                    Stock Tersedia
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
                    <th width="280px" colspan="3">Aksi</th>
                </tr>
            </thead>
            <tbody>
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
                        </td>
                        <td>
                            {{ $row->book->stock }}
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
                        Buku Belum Dikembalikan, Telat
                        @endif
                        @if(request('type') == 'finish') 
                        Buku Sudah Selesai Dipinjam
                        @endif
                        </td>
                        <td>
                        <a class="btn btn-primary" href="{{ route('rentinfo',$row['id']) }}">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $rows->appends(request()->except('page'))->links() }}
  </div>
<!-- Tabs content -->
    </div>
@endsection