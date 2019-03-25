@if(count($zones)>0)

	<option value="">Choose State</option>

	@foreach($zones as $zone)

	<option value="{{ $zone->id }}">{{ $zone->name }}</option>


	@endforeach


@endif