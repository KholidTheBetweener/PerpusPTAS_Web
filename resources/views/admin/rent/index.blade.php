@extends('layouts.dash')
@section('title', 'Peminjaman Aktif')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Kelola Pinjam</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('rent.create') }}"> Peminjaman Baru</a>
                    <a class="btn btn-primary" href="{{ url('/admin/rent/all')}}"> Catatan Peminjaman</a>
                    <a class="btn btn-warning" href="{{ url('/admin/rent/kembali')}}"> Pengembalian Buku</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'pending' || request('type') == null) active @endif" aria-current="page" href="{{route('rent.index', [ 'type' => 'pending' ])}}">Pending</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'renting') active @endif" href="{{route('rent.index', [ 'type' => 'renting' ])}}">Renting</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'overdue') active @endif" href="{{route('rent.index', [ 'type' => 'overdue' ])}}">Overdue</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'finish') active @endif" href="{{route('rent.index', [ 'type' => 'finish' ])}}">Finish</a>
  </li>
</ul>
<!-- Tabs content -->
<div class="tab-content" id="ex1-content">
  <div
    class="tab-pane fade show active"
    id="ex1-tabs-1"
    role="tabpanel"
    aria-labelledby="ex1-tab-1"
  >
  <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>Nama Buku Pinjaman</th>
                    <th>
                    @if(request('type') == 'pending' || request('type') == null)
                    Tanggal Pengajuan 
                    @endif
                    @if(request('type') == 'renting') 
                    Tanggal Pinjam
                    @endif    
                    @if(request('type') == 'overdue') 
                    Tanggal Deadline Peminjaman
                    @endif
                    @if(request('type') == 'finish') 
                    Tanggal Pengembalian
                    @endif
                    </th>
                    <th>Status</th>
                    <th width="280px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($rows->count() > 0)
                @foreach ($rows as $row)
                    <tr>
                        <td>
                        {{ $row->user->name }}
                        </td>
                        <td>
                        {{ $row->book->book_title }}
                        </td>
                        <td>
                        @if(request('type') == 'pending' || request('type') == null)
                        {{ $row->date_request }}
                        @endif
                        @if(request('type') == 'renting') 
                        {{ $row->date_rent }}
                        @endif    
                        @if(request('type') == 'overdue') 
                        {{ $row->date_due }}
                        @endif
                        @if(request('type') == 'finish') 
                        {{ $row->date_finish }}
                        @endif
                        </td>
                        <td>
                        @if(request('type') == 'pending' || request('type') == null)
                        Mengajukan Peminjaman Buku
                        @endif
                        @if(request('type') == 'renting') 
                        Buku Sedang Dipinjam
                        @endif    
                        @if(request('type') == 'overdue') 
                        Waktu Peminjaman Buku Habis dan Belum Dikembalikan
                        @endif
                        @if(request('type') == 'finish') 
                        Buku Sudah Selesai Dipinjam
                        @endif
                        </td>
                        <td>
                        @if(request('type') == 'pending' || request('type') == null)
                        <form action="{{ route('rent.destroy',$row['id']) }}" method="Post">
                                <a class="btn btn-primary show-alert-approve-box" data-toggle="tooltip" title='approve' href="{{ route('rent.approve',$row['id']) }}">Terima</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger show-alert-delete-box" data-toggle="tooltip" title='Delete'>Tolak</button>
                            </form>
                        @endif
                        @if(request('type') == 'renting') 
                        <form action="{{ route('rent.return',$row['id']) }}" method="Post">
                        <a class="btn btn-primary" href="{{ route('rent.alert',$row['id']) }}">Mendekati Deadline</a>        
                        @csrf
                                <button type="submit" class="btn btn-danger">Selesai Pinjam</button>
                            </form>
                        @endif    
                        @if(request('type') == 'overdue') 
                        <form action="{{ route('rent.return',$row['id']) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('rent.warning',$row['id']) }}">Peringati Peminjam</a>
                                @csrf
                                <button type="submit" class="btn btn-danger">Selesai Pinjam</button>
                            </form>
                        @endif
                        @if(request('type') == 'finish') 
                        <form action="{{ route('rent.destroy',$row['id']) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('rent.edit',$row['id']) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        @endif
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
  </div>
<!-- Tabs content -->
    </div>
    <script type="module">
    $(function() {
        $(document).on('click', '.show-alert-delete-box', function(event){
            var form =  $(this).closest("form");

            event.preventDefault();
            swal.fire({
                title: "Are you sure you want to delete this record?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                type: "warning",
                //buttons: ["Cancel","Yes!"],
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
        $(document).on('click', '.show-alert-approve-box', function(event){
            var form =  $(this).closest("form");

            event.preventDefault();
            swal.fire({
                title: "Are you sure you want to approve this record?",
                text: "Update this data into approval",
                icon: "warning",
                type: "warning",
                buttons: ["Cancel","Yes!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection