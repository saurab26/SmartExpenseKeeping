@extends('layouts.main')


@section('content')


	<div class="row">
		<div class="col-sm-12">
			
			<div class="row">
				
				<div class="col-sm-2">
				<h2 style="color: #000000; text-align: center;">Budgets</h2>
				</div>

				<div class="col-sm-3" style="margin-top: 22px; ">
					<a href="{{ route('budget.index') }}">
						<button class="btn btn-default btn-block  ">List All <i class="fa fa-list"></i></button>

					</a>
				</div>

				<div class="col-sm-3" style="margin-top: 22px;">
					<a href="{{ route('budget.create') }}">
						<button class="btn btn-primary btn-block ">Add New Budget <i class="fa fa-plus"></i></button>
					</a>
				</div>


				<div class="col-sm-4" style="margin-top: 22px;">
					<div class="dropdown">
						
						<select class="form-control" onchange="change_period($(this).val())">
							
							<option value="all">Choose Budget Period</option>

							@if(count($periods)>0)
							
							@foreach($periods as $row)

							<option value="{{ $row->id }}">{{ \App\Providers\Common::format_date($row->from) }} TO {{ \App\Providers\Common::format_date($row->to) }}  </option>
							@endforeach
							@endif

						</select>

					</div>
				</div>

			</div>
	
		<hr>

			<div class="row">
				
					<div class="col-sm-2 sidebar">
						@if(count($categories)>0)
							<?php $i = 0; ?>
						@foreach($categories as $row)
						<?php

						$class = ($department == $row->id ? "bg-{$colors[$i]}" : "border-{$colors[$i]}");
						$display = ($department == $row->id ? "display:none;" : "display:block;");
						$active = ($department == $row->id ? "true" : "false");


						?>

						<a href="/budgets?department={{ $row->id }}&period={{ $period }}" style="display: block;">
							<div class="departs-group-budget {{ $class }}" data-type={{ $active }}>
								<p>{{ $row->name }}</p>

								@foreach($catexpenses as $exp)
								@if($exp->category_id == $row->id){{$exp->expenseTotal}} / {{$row->budgetTotal}}
								@endif
								@endforeach
								<p> </p>
								<p style="{{ $display }}"> spent</p>
							</div>
						</a>

						<?php if($i == count($colors)-1) {$i=-1; } $i++;?>

						
						@endforeach
						@endif


					</div>


					<div class="col-sm-10">
						<div class="budget-table">
							
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="tbl-heading">Budget Item</th>
										<th class="tbl-heading">Unit</th>
										<th class="tbl-heading">Quantity</th>
										<th class="tbl-heading">Budget</th>
									</tr>
								</thead>

								<tbody>

									@if(count($budgets)>0)
									@foreach($budgets as $row)
									<tr>
										<td class="request">
											
											<h5>{{ $row->item }}</h5>
											<p>Created:<span>{{ date('d-M-Y',strtotime($row->created_at)) }}</span></p>
											<p>{{ $row->name }}</p>
										</td>
										<td class="amount">{{ \App\Providers\Common::format_currency($row->unit) }}</td>
										<td class="approvers">{{ $row->quantity }}</td>
										<td class="details">{{ \App\Providers\Common::format_currency($row->budget) }}</td>
									</tr>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>

						@if(count($budgets)>0)
						<div class="total-things col-sm-12">
							<div class="title col-sm-5">Budget Information</div>
								<div class="details col-sm-5 pull-right">
									<p>Total Budget <span>$ {{$budgetExpenseTotal->budgetTotal}}</span></p>
									<p>Spent From Budget <span>$ {{$budgetExpenseTotal->expenseTotal}}</span></p>
									<p>Remaining Budget Budget <span>$ {{$budgetExpenseTotal->remainingBalance}}</span></p>
								</div>
							
						</div>

						@else
						<h4 align="center">No Item Found.</h4>

						@endif
					</div>

			</div>

		</div>
	</div>



@endsection


@section('script')

	<script>
		
		function change_period(id)
		{
			var url = '/budgets?department={{ $department }}&period='+id;

			window.location = url;

		}

	</script>

@endsection