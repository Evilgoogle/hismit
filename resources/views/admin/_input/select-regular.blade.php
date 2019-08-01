<h2 class="card-inside-title">{{ $label }} {{ isset($required) && $required ? '*' : '' }}</h2>
<div class="row clearfix">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="form-line">
                <select
                        class="form-control show-tick"
                        id="{{ $name }}"
                        name="{{ $name }}{{ isset($array) && $array ? '[]' : '' }}"
                        title="{{ $label }}"
                        {{ isset($search) && $search ? 'data-live-search="true"' : '' }}
                        {{ isset($required) && $required ? 'required' : '' }}
                        {{ isset($array) && $array ? 'multiple' : '' }}
                        {{ isset($disabled) && $disabled ? 'disabled' : '' }}>
                        @if (!empty($options))
                            <option value="null">Выберите пункт</option>
                            @foreach($options as $op_key=>$op)
                                <option value="{{ $op_key }}" {{ $selectedId == $op_key ? 'selected' : '' }}>{{ $op }}</option>
                            @endforeach
                        @endif
                </select>
            </div>
        </div>
    </div>
</div>
