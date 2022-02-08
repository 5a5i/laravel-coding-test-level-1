@extends('layout')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="card mt-5 col-10 offset-1">
    <div class="card-header"><i class="fa fa-fw fa-globe"></i> <strong>Browse Event</strong>
        <div class="text-right">
            <a href="{{ url('/') }}" class="float-left btn btn-dark btn-sm"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                @auth
                <a href="{{ route('events.create') }}" class="btn btn-dark btn-sm"><i class="fa fa-fw fa-plus-circle"></i> Add Events</a>
                <a href="{{ route('logout') }}" class="btn btn-dark btn-sm" onclick="event.preventDefault();this.closest('form').submit();"><i class="fas fa-sign-out-alt"></i> {{ __('Log Out') }}</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-dark btn-sm"><i class="fas fa-sign-in-alt"></i> {{ __('Log In') }}</a>
                @endauth
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="col-sm-12">
            <h5 class="card-title"><i class="fa fa-fw fa-search"></i> Find Event</h5>
            <form method="get" id="eventsearch">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Event Name</label>
                            <input type="text" name="name" id="eventname" class="form-control" value="{{ old('name',app('request')->input('name')) }}" placeholder="Enter event name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Event Slug</label>
                            <input type="text" name="slug" id="eventslug" class="form-control" value="{{ old('slug',app('request')->input('slug')) }}" placeholder="Enter event slug">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Event Start At (Range)</label>
                            <div class='input-group date'>
                                <input type='text' id='eventstartat' name="startAt" class="form-control" value="{{ old('startAt',app('request')->input('startAt')) }}" placeholder="Enter event start at"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <span class="input-group-addon bg-danger text-white date-clear">
                                <span class="glyphicon glyphicon-remove"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Event End At (Range)</label>
                            <div class='input-group date'>
                                <input type='text' id='eventendat' name="endAt" class="form-control" value="{{ old('endAt',app('request')->input('endAt')) }}" placeholder="Enter event end at"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <span class="input-group-addon bg-danger text-white date-clear">
                                <span class="glyphicon glyphicon-remove"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Event Created At (Range)</label>
                            <div class='input-group date'>
                                <input type='text' id='eventcreatedat' name="createdAt" class="form-control" value="{{ old('createdAt',app('request')->input('createdAt')) }}" placeholder="Enter event created at"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <span class="input-group-addon bg-danger text-white date-clear">
                                <span class="glyphicon glyphicon-remove"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Event Updated At (Range)</label>
                            <div class='input-group date'>
                                <input type='text' id='eventupdatedat' name="updatedAt" class="form-control" value="{{ old('updatedAt',app('request')->input('updatedAt')) }}" placeholder="Enter event updated at"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                <span class="input-group-addon bg-danger text-white date-clear">
                                <span class="glyphicon glyphicon-remove"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" name="submit" value="search" id="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Search</button>
                            <button id="reset" class="btn btn-warning"><i class="fa fa-fw fa-sync"></i> Clear</button>
                            {{-- <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-danger"><i class="fa fa-fw fa-sync"></i> Clear</a> --}}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-10 offset-1">
    <hr>

    @if($errors->any())
    <div class="alert alert-danger">
        <p><strong>Opps Something went wrong</strong></p>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
    @endif

    <div class="col-12 text-left">
        Total Records {{ $events->total() }}
        <br>
        <br>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr class="bg-primary text-white">
            <td>ID</td>
            <td>Name</td>
            <td>Slug</td>
            <td>Start At</td>
            <td>End At</td>
            <td>Created At</td>
            <td>Updated At</td>
            @auth
            <td class="text-center">Action</td>
            @endauth
            </tr>
        </thead>
        <tbody>
            @if(count($events)>0)
            @foreach($events as $event)
            <tr>
                <td><a href="{{ route('events.show', $event->id)}}" class="text-primary">{{$event->id}}</a></td>
                <td>{{$event->name}}</td>
                <td>{{$event->slug}}</td>
                <td>{{$event->startAt}}</td>
                <td>{{$event->endAt}}</td>
                <td>{{$event->createdAt}}</td>
                <td>{{$event->updatedAt}}</td>
                @auth
                <td class="text-center">
                    <a href="{{ route('events.edit', $event->id)}}" class="text-primary"><i class="fa fa-fw fa-edit"></i> Edit</a>
                    <form action="{{ route('events.destroy', $event->id)}}" method="post" style="display: inline-block">
                        {{csrf_field()}}
                        {!! method_field('DELETE') !!}
                        <button class="btn btn-link text-danger" type="submit" onClick="return confirm('Are you sure to delete this event?');"><i class="fa fa-fw fa-trash"></i> Delete</button>
                    </form>
                </td>
                @endauth
            </tr>
            @endforeach
            @else
            <tr><td colspan="8" class="text-center">No Record(s) Found!</td></tr>
            @endif
        </tbody>
    </table>
    <div class="col-12 text-right">
        {{ $events->appends(request()->input())->links() }}
    </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
$(function() {
  $('#eventstartat').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    locale: {
        cancelLabel: 'Cancel',
        separator: ' to ',
        format: 'YYYY-MM-DD HH:mm:ss'
    }
  });
  $('#eventstartat').val("{{ app('request')->input('startAt') }}");
  $('#eventendat').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    locale: {
        cancelLabel: 'Cancel',
        separator: ' to ',
        format: 'YYYY-MM-DD HH:mm:ss'
    }
  });
  $('#eventendat').val("{{ app('request')->input('endAt') }}");
  $('#eventcreatedat').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    locale: {
        cancelLabel: 'Cancel',
        separator: ' to ',
        format: 'YYYY-MM-DD HH:mm:ss'
    }
  });
  $('#eventcreatedat').val("{{ app('request')->input('createdAt') }}");
  $('#eventupdatedat').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    locale: {
        cancelLabel: 'Cancel',
        separator: ' to ',
        format: 'YYYY-MM-DD HH:mm:ss'
    }
  });
  $('#eventupdatedat').val("{{ app('request')->input('updatedAt') }}");
  $('.date-clear').on('click', function() {
    $(this).siblings('input').val("");
  });
  $('#reset').on('click', function() {
    $('input.form-control').val("");
  });
});
</script>
@endsection
