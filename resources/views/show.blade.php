@extends('layout')

@section('content')

<div class="card mt-5 col-10 offset-1">
    <div class="card-header"><i class="fa fa-fw fa-plus-circle"></i> <strong>Show individual event</strong>
        <div class="text-right">
            <a href="{{ url('/') }}" class="float-left btn btn-dark btn-sm"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('events.index') }}" class="btn btn-dark btn-sm"><i class="fa fa-fw fa-globe"></i> Browse Events</a>
                @auth
                <a href="{{ route('logout') }}" class="btn btn-dark btn-sm" onclick="event.preventDefault();this.closest('form').submit();"><i class="fas fa-sign-out-alt"></i> {{ __('Log Out') }}</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-dark btn-sm"><i class="fas fa-sign-in-alt"></i> {{ __('Log In') }}</a>
                @endauth
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-2">
                <label>Event Name</label>
            </div>
            <div class="col-sm-4">:
                {{ $event->name }}
            </div>
        {{-- </div>
        <div class="row"> --}}
            <div class="col-sm-2">
                <label>Event Slug</label>
            </div>
            <div class="col-sm-4">:
                {{ $event->slug }}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <label>Event Start At</label>
            </div>
            <div class="col-sm-4">:
                {{ $event->startAt }}
            </div>
        {{-- </div>
        <div class="row"> --}}
            <div class="col-sm-2">
                <label>Event End At</label>
            </div>
            <div class="col-sm-4">:
                {{ $event->endAt }}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <label>Event Created At</label>
            </div>
            <div class="col-sm-4">:
                {{ $event->createdAt }}
            </div>
        {{-- </div>
        <div class="row"> --}}
            <div class="col-sm-2">
                <label>Event Updated At</label>
            </div>
            <div class="col-sm-4">:
                {{ $event->updatedAt }}
            </div>
        </div>
    </div>
</div>
@endsection
