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

	<div class="input-group">
		{{ Form::text($name, $value, ( isset($attributes) ? array_merge( ['class' => $classInput], $attributes ) : ['class' => $classInput] ) ) }}
		<div class="input-group-append">
			<span class="input-group-text" id="basic-addon2">
				<i class="far fa-calendar-alt"></i>
			</span>
		</div>
	</div>
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