<h2 class="card-inside-title">{{ $label }} {{ isset($required) && $required ? '*' : '' }}</h2>
<div class="row clearfix">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="form-line">
                <input
                    class="form-control"
                    type="{{ isset($type) ? $type : 'text' }}"
                    id="{{ $name }}"
                    name="{{ $name }}{{ isset($array) && $array ? '[]' : '' }}"
                    placeholder="{{ $label }}"
                    value="{{ isset($item->$name) && @$type != 'password' ? $item->$name : '' }}"
                    {{ isset($required) && $required ? 'required' : '' }}
                    {{ isset($array) && $array ? 'multiple' : '' }}
                    {{ isset($disabled) && $disabled ? 'disabled' : '' }}>
            </div>
        </div>
    </div>
</div>
