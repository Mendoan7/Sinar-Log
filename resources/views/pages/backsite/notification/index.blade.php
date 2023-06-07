@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="card mb-4 mb-xl-10">
                                
                                <div class="card-header">
                                    <div class="card-title m-0">
                                        <h5 class="fw-bolder m-0">Semua Notifikasi</h5>
                                    </div>
                                </div>

                                <div class="card-body p-9">
                                    @if (auth()->user()->notifications->count() > 0)
                                    <ul class="notification-list list-group">
                                        @foreach (auth()->user()->notifications as $notification)
                                            <li class="list-group-item {{ $notification->unread() ? ' unread' : '' }}">
                                                <a href="{{ url($notification->data['url'] . '?id=' . $notification->id) }}">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-size-14 mb-1">{{ $notification->data['title'] }}</h5>
                                                            <p class="text-truncate mb-0">{{ $notification->data['message'] }}</p>
                                                        </div>
                                                        <div class="font-size-12">{{ $notification->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                        <h6 class="text-center">Notifikasi kosong.</h6>
                                    @endif
                                </div>
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
