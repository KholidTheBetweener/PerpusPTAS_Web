@extends('layouts.app')
@section('title', 'Edit profile')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Profile</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('home') }}" enctype="multipart/form-data">
                        Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="{{ route('userupdate',$user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Foto:</strong>
                        <img src="/{{ $user->photo }}" width="200px"><input type="file" name="photo" placeholder="Profile Foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" /></i>
                        @error('photo')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama:</strong>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                            placeholder="User name">
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Komponen:</strong>
                        <select name="component" class="form-control" placeholder="Component" value="{{ $user->component }}">
                            <option value="Staff">Staff</option>
                            <option value="Siswa">Siswa</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Guru">Guru</option>
                            <option value="Dosen">Dosen</option>
                            <option value="Alumni">Alumni</option>
                            <option value="Umum">Umum</option>
                        </select>
                        @error('component')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tempat Lahir:</strong>
                        <input type="text" name="birth_place" value="{{ $user->birth_place }}" class="form-control"
                            placeholder="Tempat Lahir Pengguna">
                        @error('birth_place')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tanggal Lahir:</strong>
                        <input type="date" name="birth_date" value="{{ $user->birth_date }}" class="form-control"
                            placeholder="Tempat Lahir Pengguna">
                        @error('birth_date')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Alamat:</strong>
                        <input type="text" name="address" value="{{ $user->address }}" class="form-control"
                            placeholder="User Address">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nomer Telepon:</strong>
                        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control"
                            placeholder="User Phone">
                        @error('phone')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary ml-3">Ubah Profil</button>
            </div>
        </form>
                <div class="pull-left">
                    <h2>Ubah Email Password</h2>
                </div>
        <form action="{{ route('emailpassword') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" class="form-control" placeholder="User Email"
                            value="{{ $user->email }}">
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Password:</strong>
                        <input type="password" name="password" value="{{ $user->password }}" class="form-control"
                            placeholder="User Password">
                        @error('password')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Ubah Profil</button>
            </div>
        </form>
    </div>
@endsection