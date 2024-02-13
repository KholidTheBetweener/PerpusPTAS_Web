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
                    <a class="btn btn-primary" href="{{ route('rent.record')}}"> Catatan Peminjaman</a>
                    <a class="btn btn-warning" href="{{ route('rent.search')}}"> Pencarian Peminjaman</a>
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
    <a class="nav-link @if(request('type') == 'pending' || request('type') == null) active @endif" aria-current="page" href="{{route('rent.index', [ 'type' => 'pending' ])}}">Pengajuan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'renting') active @endif" href="{{route('rent.index', [ 'type' => 'renting' ])}}">Peminjaman</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'overdue') active @endif" href="{{route('rent.index', [ 'type' => 'overdue' ])}}">Telat</a>
  </li>
  <li class="nav-item">
    <a class="nav-link @if(request('type') == 'finish') active @endif" href="{{route('rent.index', [ 'type' => 'finish' ])}}">Dikembalikan</a>
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
                    </th>
                    <th>
                    Stock Tersedia
                    @endif
                    @if(request('type') == 'renting') 
                    Tanggal Pinjam
                    </th>
                    <th>
                    Batas Pengembalian
                    @endif    
                    @if(request('type') == 'overdue') 
                    Tanggal Deadline Peminjaman
                    @endif
                    @if(request('type') == 'finish') 
                    Tanggal Pengembalian
                    @endif
                    </th>
                    <th>Status</th>
                    <th width="280px" colspan="3">Aksi</th>
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
                        </td>
                        <td>
                            {{ $row->book->stock }}
                        @endif
                        @if(request('type') == 'renting') 
                        {{ $row->date_rent }}
                        </td>
                        <td>
                        {{ $row->date_due }}
                        @endif    
                        @if(request('type') == 'overdue') 
                        {{ $row->date_due }}
                        @endif
                        @if(request('type') == 'finish') 
                        {{ $row->date_return }}
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
                        Buku Belum Dikembalikan, Telat
                        @endif
                        @if(request('type') == 'finish') 
                        Buku Sudah Selesai Dipinjam
                        @endif
                        </td>
                        <td>
                        <a class="btn btn-primary" href="{{ route('rent.show',$row['id']) }}">Detail</a>
                        </td>
                        <td>    
                        @if(request('type') == 'pending' || request('type') == null)
                            <form action="{{ route('rent.approve',$row['id']) }}" method="Post">
                                @csrf
                                <button type="submit" class="btn btn-success show-alert-approve-box" data-toggle="tooltip" title='approve'>Terima</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('rent.destroy',$row['id']) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger show-alert-delete-box" data-toggle="tooltip" title='Delete'>Tolak</button>
                            </form>
                        @endif
                        @if(request('type') == 'renting')
                        <form action="{{ route('rent.return',$row['id']) }}" method="Post">
                        @csrf
                                <button type="submit" class="btn btn-success show-alert-done-box" title='done'>Selesai</button>
                            </form>
                        </td>
                        <td>
                        <form action="{{ route('rent.alert',$row['id']) }}" method="get">
                        @csrf
                                <button type="submit" class="btn btn-warning show-alert-warning-box" title='warning'>Peringati</button>
                        </form>
                        @endif    
                        @if(request('type') == 'overdue')
                        <form action="{{ route('rent.return',$row['id']) }}" method="Post">
                                @csrf
                                <button type="submit" class="btn btn-success show-alert-done-box" title='done'>Selesai</button>
                            </form>
                        </td>
                        <td>
                        <form action="{{ route('rent.warning',$row['id']) }}" method="get">
                        @csrf
                                <button type="submit" class="btn btn-danger show-alert-warning-box" title='warning'>Peringatan</button>
                            </form> 
                        @endif
                        @if(request('type') == 'finish') 
                        <form action="{{ route('rent.destroy',$row['id']) }}" method="Post">
                                <a class="btn btn-warning" href="{{ route('rent.edit',$row['id']) }}">Edit</a>
                                @csrf
                            </td>
                            <td>
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger show-alert-delete-box">Hapus</button>
                            </form>
                        @endif
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        {{ $rows->links() }}
  </div>
<!-- Tabs content -->
    </div>
    <script type="module">
    $(function() {
        $(document).on('click', '.show-alert-delete-box', function(event){
            var form =  $(this).closest("form");

            event.preventDefault();
            swal.fire({
                title: "Apa yakin mau menolak permintaan ini?",
                text: "Permintaan ini akan dihapus.",
                icon: "warning",
                type: "warning",
                //buttons: ["Cancel","Yes!"],
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, data dihapus!'
            }).then((willDelete) => {
                if (willDelete.value) {
                    form.submit();
                }else if(willDelete.dismiss == 'cancel'){
                        
                    }
            });
        });
        $(document).on('click', '.show-alert-approve-box', function(event){
            var form =  $(this).closest("form");

            event.preventDefault();
            swal.fire({
                title: "Apa yakin ingin menyetujui permintaan ini?",
                text: "Menyetujui Buku yang ingin dipinjam pengguna",
                icon: "warning",
                type: "warning",
                //buttons: ["Cancel","Yes!"],
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, setujui permintaan!'
            }).then((willapprove) => {
                if (willapprove.value) {
                    form.submit();
                }else if(willapprove.dismiss == 'cancel'){
                        
                    }
            });
        });
        $(document).on('click', '.show-alert-warning-box', function(event){
            var form =  $(this).closest("form");

            event.preventDefault();
            swal.fire({
                title: "Apa yakin ingin mengirim notifikasi peringatan ke pengguna?",
                text: "Kirim notifikasi peringatan ke pengguna",
                icon: "warning",
                type: "warning",
                //buttons: ["Cancel","Yes!"],
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, peringati pengguna!'
            }).then((willwarning) => {
                if(willwarning.value){
                        form.submit();
                    }else if(willwarning.dismiss == 'cancel'){
                        
                    }
            });
        });
        $(document).on('click', '.show-alert-done-box', function(event){
            var form =  $(this).closest("form");

            event.preventDefault();
            swal.fire({
                title: "Apa yaking pengguna ingin mengembalikan buku ini?",
                text: "Mengembalikan buku yang dipinjam pengguna",
                icon: "warning",
                type: "warning",
                //buttons: ["Cancel","Yes!"],
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, finish reading it!'
            }).then((willdone) => {
                if (willdone.value) {
                    form.submit();
                }else if(willdone.dismiss == 'cancel'){
                        
                    }
            });
        });
    });
</script>
@endsection