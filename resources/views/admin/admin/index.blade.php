@extends('layouts.dash')
@section('title', 'Kelola Akun Admin')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Kelola Admin</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('admin.create') }}"> Buat Akun Admin Baru</a>
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
                    <th>Email</th>
                    <th>Username</th>
                    <th width="280px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admin as $admin)
                    <tr>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->username }}</td>
                        <td>
                            <form action="{{ route('admin.destroy',$admin->id) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('admin.edit',$admin->id) }}">Edit</a>
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