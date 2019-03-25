@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <h4><b>Edit Category</b></h4>
        <hr>

        <form action="{{route('category.update',$category->id)}}" method="post" role="form" class="form-horizontal">
            {{ csrf_field() }}
            
            <input type="hidden" value="{{ $category->id}}" name="category_id">
            <input type="hidden" value="{{Auth::user()->company_id}}" name="company_id">
            <div class="form-group">
                <label for="name" class="col-sm-2 form-control-label">Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                        @if($errors->has('name'))
                        <span class="help-block">
                            <strong class="text-danger">{{$errors->first('name')}}</strong>
                        </span>
                        @endif
                </div>

                    <button class="btn btn-success" type="submit">Submit</button>

            </div>

        </form>
    </div>
</div>

@endsection