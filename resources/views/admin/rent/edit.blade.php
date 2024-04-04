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
                    <a class="btn btn-primary" href="{{ route('rent.index') }}" enctype="multipart/form-data">
                        Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('rent.update', $rent) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>User:</strong>
                        <!-- change to select-->
                        <select class="js-example-disabled-results form-control" list="user" name="name" placeholder=" {{ $rent->user->name }}, {{ $rent->user->email }}">
                            @foreach ($user as $user)
                            <option value="{{ $user->id }}">{{ $user->email }}, {{ $user->name }} </option>
                            @endforeach
                        </select>
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Buku:</strong>
                        <select class="js-example-disabled-results form-control" list="book" name="book_title" placeholder="{{ $rent->book->book_title }}">
                            @foreach ($book as $book)
                                <option value="{{ $book->id }}">{{ $book->book_title }}</option>
                                @endforeach
                        </select>
                        @error('book_title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tanggal Pinjam:</strong>
                        <input type="date" name="tgl_pinjam" value="{{ $rent->date_rent }}" class="form-control"
                            placeholder="Tanggal Pinjam">
                        @error('tgl_pinjam')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tanggal Tenggat:</strong>
                        <input type="date" name="tgl_tenggat" value="{{ $rent->date_due }}" class="form-control"
                            placeholder="Tanggal Tenggat">
                        @error('tgl_tenggat')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Status Pengembalian:</strong>
                        <input type="boolean" name="status_pengembalian" value="{{ $rent->status }}" class="form-control"
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