@extends('layouts.dash')
@section('title', 'Masukkan Buku Baru')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Tambah Buku</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('book.index') }}"> Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" aria-current="page" href="#inputbook">Masukkan Data Buku</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#importbook">Import Data Buku Melalui Excel</a>
            </li>
        </ul>
        <div class="tab-content">
        <div id="inputbook" class="tab-pane fade in active">
        <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Cover:</strong>
                        <input type="file" name="book_cover" placeholder="Cover Buku"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        @error('book_cover')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama Buku:</strong>
                        <input type="text" name="book_title" class="form-control" placeholder="Nama Buku">
                        @error('book_title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nomer Buku:</strong>
                        <input type="text" name="book_code" class="form-control" placeholder="Nomer Buku">
                        @error('book_code')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Kategori:</strong>
                        <select name="category" class="form-control" placeholder="Kategori">
                        @foreach($k as $k)    
                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                        @endforeach    
                        </select>
                        @error('category')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Author:</strong>
                        <input type="text" name="author" class="form-control" placeholder="Author Buku">
                        @error('author')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Publisher:</strong>
                        <input type="text" name="publisher" class="form-control" placeholder="Publisher Buku">
                        @error('publisher')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Deskripsi Buku:</strong>
                        <input type="text" name="book_desc" class="form-control" placeholder="Deskripsi Buku">
                        @error('book_desc')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Ketersediaan:</strong>
                        <input type="number" name="stock" class="form-control" placeholder="Ketersediaan Buku">
                        @error('stock')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </form>
        </div>
        <div id="importbook" class="tab-pane fade in active">
            <form action="{{ route('book.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Choose Excel File</label>
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
        </div>  
    </div>
    <!---->
    <script type="text/javascript">
        $(document).ready(function () {
    
            $('#scanner').val('');  // Input field should be empty on page load
            $('#scanner').focus();  // Input field should be focused on page load 
        
            $('html').on('click', function () {
                $('#scanner').focus();  // Input field should be focused again if you click anywhere
            });
        
            $('html').on('blur', function () {
                $('#scanner').focus();  // Input field should be focused again if you blur
            });
        
            $('#scanner').change(function () {
        
                if ($('#scanner').val() == '') {
                    return;  // Do nothing if input field is empty
                }
        
                $.ajax({
                    url: '/scan/save',
                    cache: false,
                    type: 'GET',
                    data: {
                        user_id: $('#scanner').val()
                    },
                    success: function (response) {
                        $('#scanner').val('');
                    }
                });
            });
        });
        </script>
@endsection