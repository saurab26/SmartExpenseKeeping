@extends('layouts.main')

@section('content')

    <div class="col-sm-8 col-sm-offset-2">
        <h4>
        <b>Edit Period</b>
        </h4>
        <hr>
        <a href="{{ route('categories-periods.index')}}"><button type="submit" class="btn btn-primary">Periods</button></a>
    
        <div class="col-sm-12">
    <h4><b>Edit Period</b></h4>

    @if($errors->has('from'))
    <span class="help-block">
        <strong class="text-danger">{{ $errors->first('from')}}</strong>
    </span>
    @endif

    @if($errors->has('to'))
    <span class="help-block">
        <strong class="text-danger">{{ $errors->first('to')}}</strong>
    </span>
    @endif


    <hr>

    <form action="{{route('period.update',$period->id)}}" method="post" role="form" class="form-horizontal">
        {{ csrf_field() }}
    <input type="hidden" value="{{Auth::user()->company_id}}" name="company_id">
    <div class="form-group">
        <label for="range" class="col-sm-2 form-control-label">Range</label>
        <div class="col-sm-8">
            
            <div class="input-datarange input-group" id="date-range">
                <input  type="text" name="from" id="from" size="15px;" value="{{date('Y-m-d',strtotime($period->from))}}">

                <span style="background-color:#51595e; color: white; padding:6px;">to</span>

                <input  type="text" name="to" id="to" size="15px;" value="{{date('Y-m-d',strtotime($period->to))}}"> 
            </div>
        </div>

            <button class="btn btn-success" type="submit">Submit</button>

    </div>

    </form>
</div>
    
    
    </div> 





@endsection

@section('script')

    <script>
            $(function(){

                $("#from").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberofMonth: 1,
                    changeYear: true,
                    dateFormat: "yy-mm-dd",
                    onClose: function( selectedDate){
                        $("#to").datepicker("option","minDate",selectedDate);
                    }

                });

                $("#to").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberofMonth: 1,
                    changeYear: true,
                    dateFormat: "yy-mm-dd",
                    onClose: function( selectedDate){
                        $("#from").datepicker("option","maxDate",selectedDate);
                    }
                });



            });



    </script>

@endsection