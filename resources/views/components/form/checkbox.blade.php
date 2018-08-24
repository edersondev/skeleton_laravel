@php
	$classErrorInput = ( $errors->has($name) ? ' is-invalid' : '' );
	$inputAttributes = isset($attributes) ? array_merge( ['class' => "custom-control-input{$classErrorInput}"], $attributes ) : ['class' => "custom-control-input{$classErrorInput}"];
	$attrFor = ( isset($attributes['id']) ? $attributes['id'] : $name );
@endphp

<div class="form-check">
	<div class="custom-control custom-checkbox">

		{{ Form::checkbox($name, $value, ( $checked == 1 ? true : false ),$inputAttributes) }}
		{{ Form::label($attrFor, $label, ['class' => 'custom-control-label']) }}

		@if ($errors->has($name))
			<div class="invalid-feedback">
				{{ $errors->first($name) }}
			</div>
		@endif

	</div>
</div>
