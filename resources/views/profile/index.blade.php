@extends('layouts.main')

@section('content')


<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-8">
        <h2>Profile</h2>
        </div>
        <div class="col-sm-4" style="margin-top: 22px;">
            <a href="{{route('home')}}">
            <button class="btn btn-primary btn-block">Dashboard <i class="fa fa-arrow-circle-left"></i></button>
        </div>
    </div>
</div>
<hr>

@endsection