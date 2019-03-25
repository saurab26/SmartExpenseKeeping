@extends('layouts.main')


@section('content')
	
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-8">
				<h2>Add New User</h2>
			</div>
			<div class="col-sm-4" style="margin-top: 22px;">

				<a href="{{ route('user.index') }}">
					<button class="btn btn-primary btn-block ">All Users <i class="fa fa-arrow-circle-left"></i></button>
				</a>
			</div>
		</div>
	</div>
	<hr>


	<div class="row">
		<div class="col-sm8 col-sm-offset-2">
			<form action="{{ route('user.store') }}" class="form-horizontal" role="form" method="post">
				
				{{ csrf_field() }}

				<input type="hidden" value="{{ Auth::user()->company_id }}" name="company_id" />
				<input type="hidden" value="{{ Auth::user()->country }}" name="country" />
				<input type="hidden" value="{{ Auth::user()->state }}" name="state" />
			

				<div class="form-group {{ $errors->has('name') ? 'has-error':'' }}">
					<label for="name" class="col-sm-2 form-control-label">Name</label>
					<div class="col-sm-10">
						<input type="text" value="{{ old('name') }}" class="form-control" name="name">
						@if($errors->has('name'))
						<span class="help-block">
							<strong class="text-danger">{{ $errors->first('name') }}</strong>
						</span>
						@endif
					</div>
				</div>
	
				<div class="form-group {{ $errors->has('email') ? 'has-error':'' }}">
					<label for="email" class="col-sm-2 form-control-label">Email</label>
					<div class="col-sm-10">
						<input type="text" value="{{ old('email') }}" class="form-control" name="email">
						@if($errors->has('email'))
						<span class="help-block">
							<strong class="text-danger">{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>
				</div>


				<div class="form-group {{ $errors->has('password') ? 'has-error':'' }}">
					<label for="password" class="col-sm-2 form-control-label">Password</label>
					<div class="col-sm-10">
						<input type="password" value="{{ old('password') }}" class="form-control" name="password">
						@if($errors->has('password'))
						<span class="help-block">
							<strong class="text-danger">{{ $errors->first('password') }}</strong>
						</span>
						@endif
					</div>
				</div>

				
					<div class="form-group {{ $errors->has('phone') ? 'has-error':'' }}">
					<label for="phone" class="col-sm-2 form-control-label">Phone</label>
					<div class="col-sm-10">
						<input type="text" value="{{ old('phone') }}" class="form-control" name="phone">
						@if($errors->has('phone'))
						<span class="help-block">
							<strong class="text-danger">{{ $errors->first('phone') }}</strong>
						</span>
						@endif
					</div>
				</div>


				<div class="form-group {{ $errors->has('city') ? 'has-error':'' }}">
					<label for="city" class="col-sm-2 form-control-label">City</label>
					<div class="col-sm-10">
						<input type="text" value="{{ old('city') }}" class="form-control" name="city">
						@if($errors->has('city'))
						<span class="help-block">
							<strong class="text-danger">{{ $errors->first('city') }}</strong>
						</span>
						@endif
					</div>
				</div>
				
				<div class="form-group {{ $errors->has('address') ? 'has-error':'' }}">
				<label for="address" class="col-sm-2 form-control-label">Address</label>
				<div class="col-sm-10">
					<input type="text" value="{{ old('address') }}" class="form-control" name="address">
					@if($errors->has('address'))
					<span class="help-block">
						<strong class="text-danger">{{ $errors->first('address') }}</strong>
					</span>
					@endif
				</div>
				</div>

				<div class="form-group {{ $errors->has('post_code') ? 'has-error':'' }}">
					<label for="post_code" class="col-sm-2 form-control-label">Post Code</label>
					<div class="col-sm-10">
						<input type="text" value="{{ old('post_code') }}" class="form-control" name="post_code">
						@if($errors->has('post_code'))
						<span class="help-block">
							<strong class="text-danger">{{ $errors->first('post_code') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group {{ $errors->has('role') ? 'has-error':'' }}" >
					<label for="role" class="col-sm-2 form-control-label">Role</label>
					<div class="col-sm-10">
						<select class="form-control" id="role" name="role" onchange="accessibilities($(this).val())">
							<option value=""> Choose Role</option>
							@if(count($roles)>0)
							@foreach($roles as $role)
							<option value="{{ $role->id }}">{{ $role->name }}</option>
							
							@endforeach
							@endif
						</select>
						@if($errors->has('role'))
						<span class="help-block">
							<strong class="text-danger">{{ $errors->first('role') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group" id="accessibilities" style="display: none;" >
					<label for="Permissions" class="col-sm-2 form-control-label">Permissions</label>
					<div class="col-sm-10">

						@if(count($companies))
						@foreach($companies as $company)
						<label for=""><input  type="checkbox" value="{{ $company->id }}" name="access[{{ $company->id }}]" onclick="categories($(this),{{ $company->id }})">{{ $company->name }}</label><br>
						
						@if(count(\App\Category::whereUser($company->id)))
						<ul style="list-style: none;" id="checkbox_{{ $company->id }}">
							@foreach(\App\Category::whereUser($company->id) as $category)
							<li><label><input type="checkbox" value="{{ $category->id }}" name="access[{{ $company->id }}][]" class="categories"> {{ $category->name }}</label></li>

							@endforeach
						</ul>
						@endif
						@endforeach
						@endif
					</div>
				</div>
				



				<div class="form-group {{ $errors->has('role') ? 'has-error':'' }}">
					<label for="status" class="col-sm-2 form-control-label">Status</label>
					<div class="col-sm-10">
						<select class="form-control" id="status" name="status">
							<option value="on" selected=""> Active</option>
							<option value="off" > Deactive</option>

						</select>
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


		function categories(e, id)


		{

			if(e.is(":checked"))
			{

			}else{

				$("#checkbox_"+id).hide();
			}

		}
		
		function accessibilities(role)
		{

				if(role==1 || role == '')
				{
					$("#accessibilities").attr("type", "checkbox");
					$("#accessibilities").show();
				}

				if(role==2)
				{
					$(".categories").attr("type", "checkbox");
					$("#accessibilities").show();
				}

				if(role==3)
				{
					$(".categories").attr("type", "radio");
					$("#accessibilities").show();
				}

		}


	</script>


@endsection