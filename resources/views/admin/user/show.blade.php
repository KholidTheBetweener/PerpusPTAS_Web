@extends('layouts.dash')
@section('title', 'Detail Akun Pengguna')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Detail Pengguna</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('user.index') }}"> Kembali Ke Index Pengguna</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table">
            <tbody>
                        
                    <tr>
                    <td>Nama</td>
                    <td>:</td>
                        <td>&ensp; {{ $user->name }}</td>
                        <td rowspan="7">
                        @if ($user->photo == null)
                        <form action="{{ route('user.photo',$user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <i class="bi bi-person-bounding-box mr-1" width="300" height="300"><input type="file" name="photo" placeholder="Profile Foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" /></i>
                        @error('photo')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                            <br>    
                                <button type="submit" class="btn btn-danger">Upload Foto</button>
                            </form>
                        @endif
                        @isset ($user->photo)
                        <img src="/{{ $user->photo }}" width="200px">
                        @endisset    
                    </td>
                    </tr>
                    <tr>
                    <td>Email</td>
                    <td>:</td>
                        <td>&ensp; {{ $user->email }}</td>
                    </tr>
                    <tr>
                    <td>Komponen</td>
                    <td>:</td>
                        <td>&ensp; {{ $user->component }}</td>
                    </tr>
                    <tr>
                    <td>Tempat Lahir</td>
                    <td>:</td>
                        <td>&ensp; {{ $user->birth_place }}</td>
                    </tr>
                    <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                        <td>&ensp; {{ $user->birth_date }}</td>
                    </tr>
                    <tr>
                    <td>Nomer Telepon</td>
                    <td>:</td>
                        <td>&ensp; {{ $user->phone }}</td>
                    </tr>
                    <tr>
                    <td>Alamat</td>
                    <td>:</td>
                        <td>&ensp; {{ $user->address }}</td>
                    </tr>
            </tbody>
        </table>
    </div>
@endsection