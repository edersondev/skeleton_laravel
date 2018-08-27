@php
  $classErrorInput = ( $errors->has($name) ? 'is-invalid' : '' );
@endphp

<div class="form-check checkbox-slider-md checkbox-slider--a checkbox-slider-primary">
  <label>
    {{ Form::checkbox($name, $value, ( $checked == 1 ? true : false ),$attributes) }}
    <span class="{{$classErrorInput}}">{{ $label }}</span>
  </label>

  @if ($errors->has($name))
    <small class="form-text text-danger">
      {{ $errors->first($name) }}
    </small>
  @endif

</div>
