@extends('layouts.dash')
@section('title', 'Pengembalian Buku')
@section('content')
<script src="{{ asset('js/app.js') }}"></script>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Pengembalian Buku</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('pinjam.index') }}"> Back</a>
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
                        <strong>Barcode Peminjaman:</strong>
                        <input type="text" name="barcode" class="form-control" placeholder="Scan Peminjaman Buku Disini" id="scanner" />
                        @error('barcode')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </form>
    </div>
@endsection