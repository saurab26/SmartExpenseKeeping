@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-8">
                <h2>Add New Expense</h2>
            </div>
            <div class="col-sm-4" style="margin-top: 22px;">
                <a href="{{ route('expense.index') }}">
                    <button class="btn btn-primary btn-block ">All Expenses <i class="fa fa-arrow-circle-left"></i></button>
                </a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
         <form action="{{route('expense.store')}}" class="form-horizontal" method="post" id="expenses" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" value="{{ Auth::user()->company_id }}" name="company_id">
            <input type="hidden" value="{{ old('outside') }}" class="form-control" name="outside" id="outside">

            <div class="form-group">
               <label for="department" class="col-sm-2 form-control-label">Budget Item</label>
               <div class="col-sm-10">
               
               <select class="form-control required " required="" id="budget_id" name="budget_id" onchange="change_budget($(this).val())">
                <option value="">Choose Budget Item</option>
                    @if(count($budgets)>0)
                        @foreach($budgets as $row)
                        <option value="{{$row->id. ' : ' .$row->outside.' : '.$row->category_id.' : '.$row->period_id}}">{{ $row->category . ' : ' .$row->item}}</option>
                        @endforeach
                        @endif
               </select>         
               </div>
            </div>

                <div class="form-group">
                    <label for="priority" class="col-sm-2 form-control-label">Priority</label>
                        <div class="col-sm-10">
                            <select class="form-control required" required="required" id="priority" name="priority">
                                <option value="">Choose Priority</option> 
                                <option value="High">High</option>
                                <option value="Medium">Medium</option> 
                                <option value="Low">Low</option>
                            </select>
                        </div>
                </div>    

                <div class="form-group {{ $errors->has('price') ? 'has-error':'' }}">
							<label for="price" class="col-sm-2 form-control-label">Price</label>
							<div class="col-sm-10">
								<input type="text" value="{{ old('price') }}" class="form-control" name="price" id="price">
                                <p class="red" id="out_of_budget" style="display:none">Sorry! Your Price is out of the Item Budget</p>
								@if($errors->has('price'))
								<span class="help-block">
									<strong class="text-danger">{{ $errors->first('price') }}</strong>
								</span>
								@endif
							</div>
						</div>

                        <div class="form-group {{ $errors->has('subject') ? 'has-error':'' }}">
							<label for="unit" class="col-sm-2 form-control-label">Subject</label>
							<div class="col-sm-10">
								<input type="text" value="{{ old('subject') }}" class="form-control" name="subject" id="subject">

								@if($errors->has('subject'))
								<span class="help-block">
									<strong class="text-danger">{{ $errors->first('subject') }}</strong>
								</span>
								@endif
							</div>
						</div>

                        <div class="form-group {{ $errors->has('description') ? 'has-error':'' }}">
							<label for="unit" class="col-sm-2 form-control-label">Description</label>
							<div class="col-sm-10">
								<textarea id="editor" name="description" class="form-control" rows="8">{{old('description')}}</textarea>

								@if($errors->has('description'))
								<span class="help-block">
									<strong class="text-danger">{{ $errors->first('description') }}</strong>
								</span>
								@endif
							</div>
						</div>

                        <div class="form-group {{ $errors->has('file') ? 'has-error':'' }}">
							<label for="unit" class="col-sm-2 form-control-label">File</label>
							<div class="col-sm-10">
								<input type="file" value="{{ old('file') }}" class="form-control" name="file" id="file">

								@if($errors->has('file'))
								<span class="help-block">
									<strong class="text-danger">{{ $errors->first('file') }}</strong>
								</span>
								@endif
							</div>
						</div>

                    <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                    </div>
                    </div>

          </form> 
        </div>
    </div>

@endsection

@section('script')

    <script>
        function change_budget(val)
        {
            val = val.split(':');

            var budget = parseInt(val[1]);

            $("#price").attr("placeholder","Budget Limit:"+budget);
            $("#price").attr("max",budget);
            $("#outside").val(budget);
        }

            $(document).ready(function(e){
                $("#price").keyup(function(e){
                    var val = $("#budget_id").val();
                    val = val.split(':');
                    var budget = parseInt(val[1]);

                    var price = $(this).val();
                    price = parseInt(price);

                    if(price>budget)
                    {
                        $("#expenses").attr("onsubmit","return false");
                        $("#price").addClass("red");
                        $("#out_of_budget").show();
                    }else
                    {
                        $("#expenses").removeAttr("onsubmit");
                        $("#price").removeClass("red");
                        $("#out_of_budget").hide();   
                    }
                });
            });


    </script>

    <script> 
        $(function() { $('textarea').froalaEditor() });
    </script>


@endsection