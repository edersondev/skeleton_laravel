<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label, ['class' => 'control-label']) }} {!! ( isset($attributes['required']) ? '<span class="asteriskField">*</span>' : '' ) !!}
    {{ Form::select($name, $arrOptions, $value, ( isset($attributes) ? array_merge( ['class' => 'form-control'], $attributes ) : ['class' => 'form-control'] ) ) }}
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>