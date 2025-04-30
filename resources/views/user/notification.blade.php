@extends('layouts.app')
@section('title', 'Halaman Notifikasi')
@section('content')
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10">
                                        <div class="card-body">
                                            <h1>
                                            Halaman Notifikasi
                                            </h1>
                                        </div>
                                        @if ($message = Session::get('success'))
                                            <div class="alert alert-success">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @endif
                                    @if(auth())
                                        @forelse($notifications as $notification)
                                            <div class="alert alert-success" role="alert">
                                            <table>
                                                <td>
                                                [{{ $notification->created_at }}] {{ $notification->data['title'] }} ({{ $notification->data['message'] }})
                                                </td>
                                                <td>
                                                <form id="{{ $notification->id }}" action="{{route('marknotify', $notification->id)}}" method="post">
                                                @csrf
                                                </form>
                                                <a  href="javascript:void(0)" onclick="document.getElementById('{{ $notification->id }}').submit()">Mark as read</a>
                                                </td>
                                            </table>    
                                            </div>

                                            @if($loop->last)
                                            <form id="form" action="{{route('marknotifyall')}}" method="POST">@csrf
                                            <a href="javascript:void(0)" onclick="document.getElementById('form').submit()">Mark all as read</a>
                                            </form>
                                            @endif
                                        @empty
                                            There are no new notifications
                                        @endforelse
                                    @endif                 
                            </div>
                        </div>
                    </div>
@endsection