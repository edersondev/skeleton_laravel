@php
	$classErrorInput = ( $errors->has($name) ? ' is-invalid' : '' );
	$classInput = "custom-control-input{$classErrorInput}";
	$inputAttributes = isset($attributes) ? array_merge( ['class' => $classInput], $attributes ) : ['class' => $classInput];
	$attrFor = ( isset($attributes['id']) ? $attributes['id'] : $name );
@endphp

<div class="form-check">
	<div class="custom-control custom-checkbox">
		{{ Form::checkbox($name, $value, (boolean)$checked, $inputAttributes) }}
		{{ Form::label($attrFor, $label, ['class' => 'custom-control-label']) }}
		@if ($errors->has($name))
			<div class="invalid-feedback">
				{{ $errors->first($name) }}
			</div>
		@endif
	</div>
</div>
