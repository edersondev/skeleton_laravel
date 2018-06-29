<div class="form-group">
	@if($label)
		{{ Form::label($name, $label, ['class' => 'control-label']) }} {!! ( isset($attributes['required']) ? '<span class="asteriskField">*</span>' : '' ) !!}
	@endif

	@php
		$classErrorInput = ( $errors->has($name) ? ' is-invalid' : '' );
		if($helpText){
			$attributes['aria-describedby'] = "{$name}HelpBlock";
		}
	@endphp

	{{ Form::email($name, $value, ( isset($attributes) ? array_merge( ['class' => "form-control{$classErrorInput}"], $attributes ) : ['class' => "form-control{$classErrorInput}"] ) ) }}
	
	@if ($errors->has($name))
		<div class="invalid-feedback">
			<strong>{{ $errors->first($name) }}</strong>
		</div>
	@endif

	@if($helpText and !$errors->has($name))
		<small id="{{$name}}HelpBlock" class="form-text text-muted">
			{{ $helpText }}
		</small>
	@endif

</div>