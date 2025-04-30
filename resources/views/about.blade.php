@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1>About</h1>
                <h1>
                     Website Perpustakaan Perkantas:
                </h1>
                <div class=" row-cols-1 row-cols-md2 g-4">
                <table>
                    <tbody>
                    <tr>
                    <td>
                    <div class="col">
                    <a href="{{route('download')}}" class="underline text-gray-900 dark:text-white">
                        <div class="card">
                        <div class="card-header">
                        <div class="ml-4 text-lg leading-7 font-semibold card-title" text-align="center">Visi</div>
                        </div>
                        <div class="card-body">
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm card-text">
                                Mempersiapkan siswa dan mahasiswa menjadi alumni yang dewasa dan menjadi berkat dalam keluarga, gereja, bangsa dan negara serta dunia dengan paduan dari informasi buku yang perpustakaan sediakan
                                </div>
                            </div>
                        </div>
                        </div>
                    </a>
                    </div>
                    </td>
                    <td>
                    <div class="col">
                    <a href="{{route('admin.login-view')}}" class="underline text-gray-900 dark:text-white">
                        <div class="card">
                        <div class="card-header">
                        <div class="ml-4 text-lg leading-7 font-semibold card-title" text-align="center">Misi</div>
                        </div>
                        <div class="card-body">                            
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm card-text">
                                • Penginjilan<br>
Pemberitaan Injil melalui Pendekatan Pribadi, Kelompok Kecil, Kebaktian Kebangunan Rohani, dll. yang bertujuan agar siswa-mahasiswa mau mendengarkan dan mempelajari isi Alkitab, menyadari dirinya sebagai manusia yang berdosa, mau bertobat dan menerima Yesus Kristus sebagai Tuhan dan Juruselamatnya secara pribadi.
<br>
• Pembinaan/Pemuridan<br>
Siswa-Mahasiswa yang telah bertobat dibina/dimuridkan melalui bimbingan di kelompok kecil, persekutuan mingguan, seminar, retreat, lokakarya, dll. yang bertujuan agar mereka bertumbuh di dalam iman, karakter, pengetahuan, nilai-nilai Kristiani, dan keterampilan; makin mengenal Tuhan dan Firman-Nya, bertumbuh dalam persekutuan dengan Tuhan dan sesama, hidup semakin serupa dengan Kristus
<br>
• Pelipatgandaan<br>
Siswa-mahasiswa yang telah dibina diberikan kepercayaan dan tanggung jawab mengembangkan karunianya dalam membina siswa-mahasiswa lain melalui program pelipatgandaan, sehingga semakin banyak siswa dan mahasiswa yang mengenal Tuhan dan menjadi murid Kristus.
<br>
• Pengutusan<br>
Siswa-mahasiswa kelak harus meninggalkan statusnya dan kembali ke tengah masyarakat. Di sinilah proses pengutusan terhadap siswa-mahasiswa yang sudah dibina. Tujuan pengutusan adalah menolong mereka mengetahui panggilan dan kehendak Allah bagi pekerjaan ataupun pelayanan mereka setelah lulus; serta membina mereka agar lebih siap menghadapi kondisi nyata di dalam kehidupannya sebagai anggota masyarakat, keluarga, bangsa dan negara.
                                </div>
                            </div>
                        </div>
                        </div>
                    </a>
                    </div>         
                    </td>
                    </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
