<h2 class="card-inside-title">{{ $label }} {{ isset($required) && $required ? '*' : '' }}</h2>
<div class="row clearfix">
    <div class="col-sm-12">
        @if (isset($type) && $type == 'color')
            <div class="input-group colorpicker colorpicker-element">
                <span class="input-group-addon">
                    <i style="background-color: {{ isset( $item->$name) && @$type != 'password' ? $item->$name : ''}};"></i>
                </span>
                <div class="form-line">
                    <input
                        class="form-control"
                        type="text"
                        id="{{ $name }}"
                        name="{{ $name }}{{ isset($array) && $array ? '[]' : '' }}"
                        placeholder="{{ $label }}"
                        value="{{ isset( $item->$name) && @$type != 'password' ? $item->$name : ''}}"
                        {{ isset($required) && $required ? 'required' : '' }}
                        {{ isset($array) && $array ? 'multiple' : '' }}
                        {{ isset($disabled) && $disabled ? 'disabled' : '' }}>
                </div>
            </div>
        @else
            <div class="form-group">
                <div class="form-line">
                    <input
                        class="form-control"
                        type="{{ isset($type) ? $type : 'text' }}"
                        id="{{ $name }}"
                        name="{{ $name }}{{ isset($array) && $array ? '[]' : '' }}"
                        placeholder="{{ $label }}"
                        value="{{ isset( $item->$name) && @$type != 'password' ? $item->$name : ''}}"
                        {{ isset($required) && $required ? 'required' : '' }}
                        {{ isset($array) && $array ? 'multiple' : '' }}
                        {{ isset($disabled) && $disabled ? 'disabled' : '' }}>
                </div>
            </div>
        @endif
    </div>
</div>
