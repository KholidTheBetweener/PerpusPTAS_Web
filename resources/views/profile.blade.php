@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1>Profile Organisasi</h1>
                <h1>
                     Perkantas Semarang:
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
                        <div class="ml-4 text-lg leading-7 font-semibold card-title" text-align="center">Perkantas</div>
                        </div>
                        <div class="card-body">
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm card-text">
                                Perkantas telah 50 tahun melayani siswa, mahasiswa, dan alumni. Kini tidak hanya ada satu kelompok kecil, tetapi ribuan. Tidak hanya satu persekutuan kampus, melainkan sudah ratusan kampus yang dijangkau oleh pelayanan Perkantas di seluruh Indonesia. Perkantas pun tidak hanya ada di Jakarta tetapi telah tersebar hampir di seluruh provinsi di Indonesia.

Para alumni yang tersebar di penjuru nusantara menjadi rekan pelayanan yang strategis bagi perintisan dan pengembangan pelayanan di daerah-daerah perintisan. Pelayanan Perkantas juga menjangkau siswa, mahasiswa, dan alumni di dunia maya, khususnya melalui media sosial, baik yang dikelola oleh kantor nasional, maupun masing-masing daerah. Dengan adanya pandemi COVID-19, sejak Maret 2020 banyak aktivitas pelayanan yang terpaksa tidak dapat dilaksanakan secara tatap muka. Puji Tuhan, di tengah berbagai kendala, seperti keterbatasan sinyal dan kuota, secara umum pelayanan yang dilangsungkan secara daring dapat berjalan dengan baik.

Perkantas hadir bagi negeri mengerjakan mandat Allah, yaitu menjadikan semua bangsa murid-Nya. Kiranya Dia yang memanggil dan mengutus juga terus memimpin dan memperlengkapi pelayanan yang besar ini. Segala kemuliaan hanya bagi Tuhan!
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
