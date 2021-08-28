@extends('frontend.layouts.app')

@section('title','Notification Detail');
@section('content')
<div>
    <div class="card">
        <div class="card-body text-center">
            <div class="text-center">
                <img src="{{asset('img/notification.png')}}" alt="" style="width: 220px;">
            </div>
            <h6 class="text-center">{{$notification->data['title']}}</h6>
            <p class="text-center text-muted mb-1">{{$notification->data['message']}}</p>
            <p class="text-center mb-2"><small>{{Carbon\Carbon::parse($notification->created_at)->format('Y-m-d h:i:s A')}}</small></p>
            <a href="{{$notification->data['web_link']}}" class="btn btn-theme btn-sm">Continue</a>
        </div>
    </div>
</div>
@endsection
