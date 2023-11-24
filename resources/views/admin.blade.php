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
                                <div class="card mb-4">
                                    <a href = "{{route('admin.index')}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Kelola Admin</h2>
                                    </div>
                                    </a>
                                    <a href = "{{route('user.index')}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Kelola User</h2>
                                    </div>
                                    </a>
                                    <a href = "{{route('book.index')}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Kelola Buku</h2>
                                    </div>
                                    </a>
                                    <a href = "{{route('rent.index')}}">
                                    <div class="card-body">
                                        <h2 class="card-title">Awasi Peminjaman Buku</h2>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection