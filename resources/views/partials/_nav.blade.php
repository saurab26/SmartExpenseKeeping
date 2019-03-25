<nav class="navbar navbar-default navbar-static-top head-style">


	<div class="container">
		
		<div class="row">
			
			<div class="navbar-header" >
				
				<a href="{{route('home')}}" class="navbar-brand heading-style">
				
					@if(Auth::user()->company_id!=NULL)
					{{Auth::user()->company_name}}
					@else
					{{trans('app.companies-title')}} <i class="fab fa-btc"></i>
					@endif
				
				</a>

			</div>

			<div id="navbar" class="navbar-collapse collapse">
				
				<ul class="nav navbar-nav navbar-toggler-right">

					<li><a class="heading-style" href="{{route('company.index')}}">Change Company</a></li>
					<li><a class="heading-style" href="{{route('categories-periods.index')}}"> Depart. & Periods</a></li>
					<li><a class="heading-style" href="{{ route('budget.index') }}">Budgets</a></li>
					<li><a class="heading-style" href="{{ route('expense.index') }}">Expense Request</a></li>
					<li><a class="heading-style" href="{{ route('user.index')}}">Users  <i class="fa fa-user"></i></a></li>
					<li><a class="heading-style" href="">Reports  <i class="fa fa-eye"></i></a></li>


					<li> 

						<form class="navbar-form navbar-left" action="{{route('expense.search')}}" method="post" role="search">
							{{csrf_field()}}
							<input type="hidden" name="company_id" value="{!! Auth::user()->company_id !!}">
							<div class=" form-group">

									<input type="text" class="form-control" name="search" placeholder="Search">
								
							</div>

							<button type="submit" style=" padding: 6px 10px;" class="btn btn-default">
								<i class="fa fa-search"></i>
							</button>


						</form>


					</li>


					<li><img src="/img/favicon.png" class="img-rounded avatar" height="30px" style="position: relative; margin-top:0px; margin-right: 10px; width: 32px;"></li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle dropdown dropdown-border" data-toggle="dropdown" role="button"><i class="fa fa-cog fa-lg heading-style"></i><span class="heading-style caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="{{route('profile.index')}}">{{Auth::user()->name}}</a></li>
							<li><a href="{{route('profile.index')}}">Profile</a></li>
							<li><a href="{{ route('logout') }}">Logout</a></li>
						</ul>
					</li>
					
					
				</ul>
				

			</div>

	</div><!-- end row -->

	</div><!-- end nav bar container-->
	


</nav>