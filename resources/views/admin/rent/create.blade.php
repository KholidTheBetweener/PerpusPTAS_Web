@extends('layouts.dash')
@section('title', 'Peminjaman Baru')
@section('content')
<script src="{{ asset('js/app.js') }}"></script>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Peminjaman Baru</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('rent.index') }}"> Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('rent.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Username:</strong>
                        <!-- change to select-->
                        <input list="user" name="name" class="form-control" placeholder="Email User">
                            <datalist id="user">
                                @foreach ($user as $user)
                                <option value="{{ $user->email }}">
                                @endforeach
                            </datalist>
                        @error('username')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Buku:</strong>
                        <input list="book" name="book_title" class="form-control" placeholder="Judul Buku">
                            <datalist id="book">
                                @foreach ($book as $book)
                                <option value="{{ $book->book_title }}">
                                @endforeach
                            </datalist>
                        @error('book_title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </form>
    </div>
@endsection