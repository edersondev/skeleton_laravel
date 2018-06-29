<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label($name, $label) }} {!! ( isset($attributes['required']) ? '<span class="asteriskField">*</span>' : '' ) !!}
    <div class="input-group">
        @if (isset($addon['prefix']))
            <span class="input-group-addon">{{ $addon['prefix'] }}</span>
        @endif
            {{ Form::text($name, $value, ( isset($attributes) ? array_merge( ['class' => 'form-control'], $attributes ) : ['class' => 'form-control'] ) ) }}
        @if (isset($addon['sufix']))
        <span class="input-group-addon">{{ $addon['sufix'] }}</span>
        @endif
    </div>
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>