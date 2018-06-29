<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    {{ Form::label(null, $label, ['class' => 'control-label']) }} {!! ( isset($attributes['required']) ? '<span class="asteriskField">*</span>' : '' ) !!}
    @if ( count($arrOptions) > 0 )
        @foreach( $arrOptions as $option )
        <div class="radio">
            <label>
                @if ( isset($value) && $value == $option->id )
                    {{ Form::radio($name,$option->id,true) }}
                @else
                    {{ Form::radio($name,$option->id) }}
                @endif
                {{ $option->name }}
            </label>
        </div>
        @endforeach
    @endif
    @if ($errors->has($name))
        <span class="help-block">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>