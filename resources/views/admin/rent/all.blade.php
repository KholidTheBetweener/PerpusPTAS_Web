@extends('layouts.dash')
@section('title', 'Catatan Peminjaman')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Kelola Pinjam</h2>
                </div>
                <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('rent.create') }}"> Peminjaman Baru</a>
                    <a class="btn btn-primary" href="{{ route('rent.index')}}"> Peminjaman Aktif</a>
                    <a class="btn btn-warning" href="{{ route('rent.search')}}"> Pencarian Buku</a>
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
                <th>Nama User</th>
                    <th>Nama Buku Pinjaman</th>
                    <th>Status</th>
                    <th width="280px">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($rows as $row)
                    <tr>
                        <td>
                        {{ $row->user->name }}
                        </td>
                        <td>
                        {{ $row->book->book_title }}
                        </td>
                        <td>
                        @if($row->status == NULL && $row->date_request != NULL && $row->date_rent == NULL)
                        Mengajukan Peminjaman Buku
                        @endif
                        @if($row->status == TRUE && $row->date_rent != NULL && $row->date_due > $now) 
                        Buku Sedang Dipinjam
                        @endif    
                        @if($row->status == TRUE && $row->date_due < $now) 
                        Buku Belum Dikembalikan, Telat
                        @endif
                        @if($row->status == FALSE && $row->date_return != NULL) 
                        Buku Sudah Selesai Dipinjam
                        @endif
                        </td>
                        <td>
                        <a class="btn btn-primary" href="{{ route('rent.show',$row['id']) }}">Detail</a>
                        </td>
                        <td>    
                        @if($row->status == NULL && $row->date_request != NULL & $row->date_rent == NULL)
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
                        @if($row->status == TRUE && $row->date_rent != NULL && $row->date_due > $now)
                        <form action="{{ route('rent.return',$row['id']) }}" method="Post">
                        @csrf
                                <button type="submit" class="btn btn-success show-alert-done-box" title='done'>Selesai</button>
                            </form>
                        </td>
                        <td>
                        <form action="{{ route('rent.alert',$row['id']) }}" method="Post">
                        @csrf
                                <button type="submit" class="btn btn-warning show-alert-warning-box" title='warning'>Peringati</button>
                        </form>
                        @endif    
                        @if($row->status == TRUE && $row->date_due < $now)
                        <form action="{{ route('rent.return',$row['id']) }}" method="Post">
                                @csrf
                                <button type="submit" class="btn btn-success show-alert-done-box" title='done'>Selesai</button>
                            </form>
                        </td>
                        <td>
                        <form action="{{ route('rent.warning',$row['id']) }}" method="Post">
                        @csrf
                                <button type="submit" class="btn btn-danger show-alert-warning-box" title='warning'>Peringatan</button>
                            </form> 
                        @endif
                        @if($row->status == FALSE && $row->date_return != NULL) 
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
            </tbody>
        </table>
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