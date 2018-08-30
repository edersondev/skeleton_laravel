<div class="form-group">
	@if($label)
		{{ Form::label($name, $label) }} {!! ( !isset($attributes['required']) ? '<small class="text-muted"> (opcional)</small>' : '' ) !!}
	@endif

	@php
		$classErrorInput = ( $errors->has($name) ? ' is-invalid' : '' );
		$classInput = "form-control{$classErrorInput}";
		if($helpText){
			$attributes['aria-describedby'] = "{$name}HelpBlock";
		}
	@endphp

	{{ Form::text($name, $value, ( isset($attributes) ? array_merge( ['class' => $classInput], $attributes ) : ['class' => $classInput] ) ) }}
	@if ($errors->has($name))
		<div class="invalid-feedback">
			<strong>{{ $errors->first($name) }}</strong>
		</div>
	@endif

	@if($helpText and !$errors->has($name))
		<small id="{{$name}}HelpBlock" class="form-text text-muted">
			{!! $helpText !!}
		</small>
	@endif

</div>