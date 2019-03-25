<!DOCTYPE html>
<html lang="en">

	@include('partials._head')
	
<body>
	
	@include('partials._nav')

			<div class="container">
				
						@include('partials._errors')

						@yield("content")


			@include('partials._footer')

						
			</div>

			

		@include('partials._script')


	@yield("script")



</body>
</html>