@extends('layouts.main')

@section('content')

        <div class="row">
            <div class="col-sm-12">
				<div class="row">
				
					<div class="col-sm-2">
						<h2 style="color: #000000; text-align: center;">Expenses</h2>
					</div>

					<div class="col-sm-3" style="margin-top: 22px; ">
						<a href="{{ route('expense.index') }}">
							<button class="btn btn-default btn-block  ">List All <i class="fa fa-list"></i></button>

						</a>
					</div>

					<div class="col-sm-3" style="margin-top: 22px;">
						<a href="{{ route('expense.create') }}">
							<button class="btn btn-primary btn-block ">Add New Expense <i class="fa fa-plus"></i></button>
						</a>
					</div>

					<div class="col-sm-4" style="margin-top: 22px;">
						<div class="dropdown">
							
							<select class="form-control" onchange="change_period($(this).val())">
								
								<option value="all">Choose Budget Period</option>

								@if(count($periods)>0)
								
								@foreach($periods as $row)

								<option value="{{ $row->id }}"<?php if($period ==$row->id){echo 'selected = "selected"';} ?>>{{ \App\Providers\Common::format_date($row->from) }} TO {{ \App\Providers\Common::format_date($row->to) }}  </option>
								@endforeach
								@endif

							</select>

						</div>
					</div>

				
				</div>
                
				<div class="row">
					<div class="col-sm-2 sidebar">
					<div>
						<nav>
							<ul class="nav navbar-inverse" style="line-height: .1; padding: 10px;">
								<li>
									<a href="/expenses?department={{$department}}&status=all&period={{$period}}&page=1" <?php if($status=="all") {echo 'class="bg-blue"';}  ?> >All Expenses</a>
								</li>
								<li>
									<a href="/expenses?department={{$department}}&status=Pending&period={{$period}}&page=1" <?php if($status=="Pending") {echo 'class="bg-blue"';}  ?>>Pending</a>
								</li>
								<li>
									<a href="/expenses?department={{$department}}&status=Denied&period={{$period}}&page=1" <?php if($status=="Denied") {echo 'class="bg-blue"';}  ?>>Denied</a>
								</li>
								<li>
									<a href="/expenses?department={{$department}}&status=Approved&period={{$period}}&page=1" <?php if($status=="Approved") {echo 'class="bg-blue"';}  ?>>Approved</a>
								</li>
								<li>
									<a href="/expenses?department={{$department}}&status=Closed&period={{$period}}&page=1" <?php if($status=="Closed") {echo 'class="bg-blue"';}  ?>>Closed</a>
								</li>
							</ul>
						</nav>
					</div>
					<div class="department">
						<select class="form-control" data-placeholder="Departments" onchange="change_department($(this).val())">
							<option value="all">All Departments</option>
							@if(count($categories)>0)
							@foreach($categories as $row)
							<option value="{{$row->id}}" <?php if($department ==$row->id){echo 'selected = "selected"';} ?> >{{$row->name}}</option>
							@endforeach
							@endif
						</select>
					</div>
					
					</div>
					<div class="col-sm-10">
					
						<div class="budget-table">

							<table class="table table-bordered">

								<thead>
									<tr>
										<th class="tbl-heading"><input type="checkbox" class="checkAll"></th>
										<th class="tbl-heading" style="text-align: left;">Request</th>
										<th class="tbl-heading" >$</th>
										<th class="tbl-heading" >Approves</th>
										<th class="tbl-heading" >Details</th>
									</tr>
								</thead>
								<tbody>
									<form action ="/expenses/editstatus" method="post" role="form">
									{{csrf_field()}}

										@if(count($expenses)>0)
										@foreach($expenses as $row)
										@if($row->company_id ==Auth::user()->company_id)

										<?php
											$color="purple";
											if($row->status=="Pending"){$color="yellow";}
											if($row->status=="Approved"){$color="green";}
											if($row->status=="Denied"){$color="red";}
											if($row->status=="Closed"){$color="black";}
										?>

										<tr class="border-{{ $color }}">
											<td style= "width: 30;border-right: none;vertical-align: middle;">
												<input class="expenses_checkbox" type="checkbox" name="expenses[]" value="{{$row->id}}">
											</td>
											<td style="width: 98800px; text-align: left;">
											<h5>
											<a href="{{route('expense.show',$row->id)}}">
												{{$row->subject}}
											</a>
											/
											<span>{{$row->item}} ( <span style="color: #142fba;">{{\App\Providers\Common::format_currency($row->budget-$row->price)}} BL</span>)</span>
											</h5>

												<p>From:<span>{{$row->user}}</span> Created at:<span>{{date('d-M-Y',strtotime($row->created_at))}}</p>
												@if($row->comments!='')
												<p><strong>Comments:</strong>{{ $row->comments}}</p>
												@endif
												<div style="clear: both; height: 5px;"></div>
												
												<div id="comment_box_{{ $row->id }}" style="display: none;">
														<div style="float: left; margin-top: 8px;"><strong>Comments: </strong></div>
														<textarea class="validatecommentbox" name="comments[{{$row->id}}]" id="comments_{{$row->id}}" style="width:320px; height:42px; margin-left:10px;"></textarea>
												</div>
											</td>
											<td>
												<p>{{\App\Providers\Common::format_currency($row->budget)}}</p>
												<a href="" style="text-decoration: none;">
													<span class="expense-overdue bg-{{$color}}">
														{{$row->status}}
													</span>
												</a>

											</td>
											<td>

												@if($row->approver==""&&$row->status=="Pending")
												<p>Not Approved Yet!</p>
												@elseif($row->approver!=""&&$row->logo!="")
												<p align="center"><img src="{{asset('uploads/'.$row->logo)}}" alt="logo" width="25px"></p>
												<p>{{$row->user}}</p>
												<p>{{$row->email}}</p>
												@elseif($row->approver!=""&&$row->logo=="")
												<p>{{$row->user}}</p>
												<p>{{$row->email}}</p>

												@endif

											</td>
											<td>
												<div class="details-expense">
													<h5>{{$row->category}}</h5>
													<p><span>${{$row->price}}</span>requested</p>
													<p>
														<span style="color: #56ea48;">{{\App\Providers\Common::format_currency($row->budget-$row->price)}}</span>
													</p>
													<p><strong>Priority:</strong>{{$row->priority}}</p>
												</div>
											
											
											</td>
										</tr>
										@endif
										@endforeach
										@endif
								</tbody>
							</table>
							@if(count($expenses)>0)
								<div class="col-sm-4">{!! $expenses->render(); !!}</div>
								@if(Auth::user()->role!=3)
								<div class="col-sm-8 status_trigger" style="margin-top: 25px">

								<div id="com_warnings" style="color:red;margin-bottom:10px;display:none;">Please fill comment box there are required.</div> 
								<div id="acom_warnings" style="color:red;margin-bottom:10px;display:none;">Please select the Request first.</div>
								<button class="btn btn-danger" name="status" id="deniedsubmitbtn" value="Denied" type="submit" style="visibility:hidden;">Deny</button>
								<button class="btn btn-success" name="status" id="approvesubmitbtn" value="Approved" type="submit" style="visibility:hidden;">Approve</button>
								<button class="btn btn-success" name="status" id="closesubmitbtn" value="Closed" type="submit" style="visibility:hidden;">Close</button>
									<button class="btn btn-default pull-right" type="button" style="background-color: #000000; color: #ffffff;" onclick="closeexpenses()">Close</button>
									<button class="btn btn-danger pull-right" type="button" onclick="denyexpenses()">Deny</button>
									<button class="btn btn-success pull-right" type="button" onclick="approveexpenses()">Approve</button>
								
								</div>
								@endif
								@else
								<h4 align="center">No Item Found.</h4>
								@endif
							</form>			
						</div>
					</div>
				</div>
            </div>
        </div>

@endsection

@section('script')
<script>
	function change_period(id)
	{
		var url  = '/expenses?department={{ $department }}&status={{ $status }}&period='+id+'';
		window.location = url;
	}
</script>
<script>
	function change_department(id)
	{
		var url  = '/expenses?department='+id+'&status={{ $status }}&period={{$period}}';
		window.location = url;
	}
</script>	

<script>

	function denyexpenses()
	{
		$(".expenses_checkbox").each(function(){
			var checking = $(this).is(':checked');
			var checkboxid = $(this).val();
			if(checking === true)
			{
				window.scrollTo(0,200);
				$("#comment_box_"+checkboxid).slideDown('slow');
			}else{
				$("#comment_box_"+checkboxid).slideDown('slow');
					$("#com_warnings").hide();
			}
		}); 

		var commentcounter = 0;
		$(".expenses_checkbox").each(function(){
			var checking = $(this).is(':checked');
			if(checking ===true)
			{
				commentcounter++;
			}
		});

		var allfilledtextarea = $(".validatecommentbox").filter(function(){
			return this.value;
		});
		if(allfilledtextarea.length == 0)
		{
			$("#com_warnings").show().fadeOut(2500);
		}else if(allfilledtextarea.length == commentcounter)
		{
			var confirmation = comfirm('Are You sure?');
			$("#com_warnings").hide();
			if(confirmation ===true)
			{
				$("#deniedsubmitbtn").trigger('click');
			}
		}
	}	

	function closeexpenses()
	{
		var commentcounter = 0;

		$(".expenses_checkbox").each(function(){
			var checking = $(this).is(':checked');
			if(checking === true)
			{
				commentcounter++;
			}
		});

		if(commentcounter>0)
		{
			var confirmation = confirm('Are you sure?');
			if(confirmation ===true)
				$("#closesubmitbtn").trigger('click');
		}else{
			$("#acom_warnings").show().fadeOut(2500);
		}
	}

	function approveexpenses()
	{
		var commentcounter = 0;

		$(".expenses_checkbox").each(function(){
			var checking = $(this).is(':checked');
			if(checking === true)
			{
				commentcounter++;
			}
		});

		if(commentcounter>0)
		{
			var confirmation = confirm('Are you sure?');
			if(confirmation ===true)
			{
				$("#approvesubmitbtn").trigger('click');
			}
		}else
		{
			$("#acom_warnings").show().fadeOut(2500);
		}
	}

	$(document).ready(function(){
		$('.checkAll').on('click',function(){
			$(this).closest('table').find('tbody :checkbox').prop('checked',this.checked).closest('tr').toggleClass('selected',this.checked);

		});
	});

</script>

@endsection