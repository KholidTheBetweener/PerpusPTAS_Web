@extends('layouts.dash')
@section('title', 'Peminjaman Baru')
@section('content')
@stack('scripts')
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
                        <strong>User:</strong>
                        <!-- change to select-->
                        <select name="name" id="user" class="form-control" placeholder="Nama Pengguna" style="width:102%;">
                            @foreach ($user as $key => $user)
                            <option value="{{ $key }}">{{ $user }}</option>
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
                        <select class="form-control" id="book" name="book_title" placeholder="Judul Buku" style="width:102%;">
                            @foreach ($book as $key => $book)
                            <option value="{{ $key }}">{{ $book }}</option>
                            @endforeach
                        </select>
                        @error('book_title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                &nbsp;
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </form>
    </div>
    <script type="module">
    var path = "{{ route('user.search') }}";
    $('#user').select2({
        placeholder: 'Select an user',
        ajax: {
          url: path,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });
      
    var path2 = "{{ route('book.search') }}";
      $('#book').select2({
        placeholder: 'Select a book',
        ajax: {
          url: path2,
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.book_title,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });
</script>
@endsection