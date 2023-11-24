@extends('layouts.dash')
@section('title', 'Kelola Akun Pengguna')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Kelola Pengguna</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('user.create') }}"> Buat Pengguna Baru</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Komponen</th>
                    <th>Email</th>
                    <th width="280px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->component }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form action="{{ route('user.destroy',$user->id) }}" method="Post">
                            <a class="btn btn-success" href="{{ route('user.show',$user->id) }}">Detail</a>    
                            <a class="btn btn-warning" href="{{ route('user.edit',$user->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
@endsection