<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label, ['class' => 'control-label']) }} {!! ( isset($attributes['required']) ? '<span class="asteriskField">*</span>' : '' ) !!}
    <div class="input-group date">
        {{ Form::text($name, $value, ( isset($attributes) ? array_merge( ['class' => 'form-control'], $attributes ) : ['class' => 'form-control'] ) ) }}
        <span class="input-group-addon">
            <i class="glyphicon glyphicon-th"></i>
        </span>
    </div>
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>