@extends('layouts.dash')
@section('title', 'Admin Dashboard')
@section('content')
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10">
                                        <div class="card-body">
                                            <h1>
                                            Hello Admin, Selamat Datang Di Perpustakaan Perkantas Back-Office Website!
                                            </h1>
                                        </div>
                                        @if(auth())
    @forelse($notifications as $notification)
        <div class="alert alert-success" role="alert">
            [{{ $notification->created_at }}] {{ $notification->data['title'] }} ({{ $notification->data['message'] }})
            <a href="#" class="float-right mark-as-read" data-id="{{ $notification->id }}">
                Mark as read
            </a>
        </div>

        @if($loop->last)
            <a href="#" id="mark-all">
                Mark all as read
            </a>
        @endif
    @empty
        There are no new notifications
    @endforelse
@endif
                                <div class="card mb-4">
                                <table>
                            <tbody>
                            <tr>
                            <td>
                                <a href = "{{route('admin.index')}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Kelola Admin</h2>
                                        <p>{{ $admin }} akun admin</p>
                                    </div>
                                    </a>
                            </td>
                            <td>
                                <a href = "{{route('user.index')}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Kelola Pengguna</h2>
                                        <p>{{ $user }} akun pengguna</p>
                                    </div>
                                    </a>
                            </td>
                            <td>
                                <a href = "{{route('book.index')}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Kelola Buku</h2>
                                        <p>{{ $book }} buku perpustakaan</p>
                                    </div>
                                    </a>
                            </td>
                            </tr>
                            <tr>
                            <td>
                            <a href = "{{route('rent.index', [ 'type' => 'pending' ])}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Pengajuan Peminjaman Buku</h2>
                                        <p>{{ $apply }} pengajuan pinjam buku</p>
                                    </div>
                                    </a>
                            </td>
                            <td>
                            <a href = "{{route('rent.index', [ 'type' => 'renting' ])}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Peminjaman Buku Sedang Berjalan</h2>
                                        <p>{{ $rent }} buku sedang dipinjam oleh pengguna</p>
                                    </div>
                                    </a>
                            </td>
                            <td>
                            <a href = "{{route('rent.index', [ 'type' => 'overdue' ])}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Telat Pengembalian Buku</h2>
                                        <p>{{ $due }} pengguna telat mengembalian buku</p>
                                    </div>
                                    </a>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
@endsection