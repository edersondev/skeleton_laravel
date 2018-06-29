<div class="checkbox{{ $errors->has($name) ? ' has-error' : '' }}">
    <label>
        {{ Form::checkbox($name, $value, ( $checked == 1 ? true : false )) }}
        {{ $label }}
    </label>
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>