@if ( count($errors) )
	@foreach( $errors->all() as $error )
		<div class="message-box bg-danger">{{ $error }}</div>
	@endforeach
@endif