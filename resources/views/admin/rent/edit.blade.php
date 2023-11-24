@extends('layouts.dash')
@section('title', 'Edit Peminjaman')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Peminjaman</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('pinjam.index') }}" enctype="multipart/form-data">
                        Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('pinjam.update',$pinjam->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama User:</strong>
                        <input type="text" name="username" value="{{ $pinjam->name }}" class="form-control"
                            placeholder="User name">
                        @error('username')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Buku:</strong>
                        <input type="text" name="nama_buku" class="form-control" placeholder="Nama Buku"
                            value="{{ $pinjam->nama_buku }}">
                        @error('nama_buku')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tanggal Pinjam:</strong>
                        <input type="datetime" name="tgl_pinjam" value="{{ $pinjam->tgl_pinjam }}" class="form-control"
                            placeholder="Tanggal Pinjam">
                        @error('tgl_pinjam')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tanggal Tenggat:</strong>
                        <input type="datetime" name="tgl_tenggat" value="{{ $pinjam->tgl_tenggat }}" class="form-control"
                            placeholder="Tanggal Tenggat">
                        @error('tgl_tenggat')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Status Pengembalian:</strong>
                        <input type="boolean" name="status_pengembalian" value="{{ $pinjam->status_pengembalian }}" class="form-control"
                            placeholder="Tanggal Pinjam">
                        @error('status_pengembalian')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </form>
    </div>
@endsection