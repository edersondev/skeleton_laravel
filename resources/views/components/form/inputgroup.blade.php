<div class="form-group">
	@if($label)
		{{ Form::label(( isset($attributes['id']) ? $attributes['id'] : $name ), $label) }} {!! ( !isset($attributes['required']) ? '<small class="text-muted"> (opcional)</small>' : '' ) !!}
	@endif
	<div class="input-group">
		@if (isset($addon['prefix']))
			<div class="input-group-prepend">
				<span class="input-group-text">{!! $addon['prefix'] !!}</span>
			</div>
		@endif

		@php
			$classErrorInput = ( $errors->has($name) ? ' is-invalid' : '' );
			if($helpText){
				$attributes['aria-describedby'] = "{$name}HelpBlock";
			}
    @endphp
		{{ Form::text($name, $value, ( isset($attributes) ? array_merge( ['class' => "form-control{$classErrorInput}"], $attributes ) : ['class' => "form-control{$classErrorInput}"] ) ) }}

		@if (isset($addon['sufix']))
			<div class="input-group-append">
				<span class="input-group-text">{!! $addon['sufix'] !!}</span>
			</div>
		@endif

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
</div>