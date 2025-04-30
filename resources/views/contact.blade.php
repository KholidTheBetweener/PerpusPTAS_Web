@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1>Contact</h1>
                <h1>
                     Jika ada masalah Hubungi:
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
                        <div class="ml-4 text-lg leading-7 font-semibold card-title" text-align="center">Website</div>
                        </div>
                        <div class="card-body">
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm card-text">
                                Pemegang Website
                                </div>
                            </div>
                        </div>
                        </div>
                    </a>
                    </div>
                    </td>
                    <td>
                    <div class="col">
                    <a href="whatsapp.com/channel/0029VadEsYC9MF8vOfxNpx2B" class="underline text-gray-900 dark:text-white">
                        <div class="card">
                        <div class="card-header">
                        <div class="ml-4 text-lg leading-7 font-semibold card-title" text-align="center">Staff</div>
                        </div>
                        <div class="card-body">                            
                            <div class="ml-12">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm card-text">
                                WA: Perkantas Semarang

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
