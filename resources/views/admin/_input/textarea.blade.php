<h2 class="card-inside-title">{{ $label }} {{ isset($required) && $required ? '*' : '' }}</h2>
<div class="row clearfix">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="form-line">
                <textarea
                    class="form-control {{ isset($editor) && $editor ? 'text-editor' : '' }}{{ isset($editor_type) && $editor_type ? '-'.$editor_type : '' }}"
                    id="{{ $name }}"
                    name="{{ $name }}{{ isset($array) && $array ? '[]' : '' }}"
                    placeholder="{{ $label }}"
                    {{ isset($required) && $required ? 'required' : '' }}
                    {{ isset($array) && $array ? 'multiple' : '' }}
                    {{ isset($disabled) && $disabled ? 'disabled' : '' }}><?php if (isset($editor) && $editor) {?>{!! isset($item->$name) ? $item->$name : '' !!}<?php } else {?>{{ isset($item->$name) ? $item->$name : '' }}<?php } ?></textarea>
            </div>
        </div>
    </div>
</div>