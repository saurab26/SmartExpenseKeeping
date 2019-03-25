@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            @include('periods.create-period')
            @include('categories.create-category')
        
        </div>
    
    </div>

    <hr>

    <div class="row">
        @include('periods.list-period')

        @include('categories.list-category')
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