<h2 class="card-inside-title">{{ $label }} {{ isset($required) && $required ? '*' : '' }}</h2>
<div class="row clearfix">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="form-line">
                <input
                    class="filled-in chk-col-blue"
                    type="checkbox"
                    id="{{ $name }}"
                    name="{{ $name }}{{ isset($array) && $array ? '[]' : '' }}"
                    {{ isset($item->$name) && $item->$name ? 'checked' : '' }}
                    {{ empty($item) && isset($default) && $default ? 'checked' : '' }}
                    {{ isset($required) && $required ? 'required' : '' }}
                    {{ isset($array) && $array ? 'multiple' : '' }}
                    {{ isset($disabled) && $disabled ? 'disabled' : '' }}>
                <label for="{{ $name }}"></label>
            </div>
        </div>
    </div>
</div>