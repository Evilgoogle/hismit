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
                        @foreach($options as $o)
                            <option value="{{ $o->$oKey }}" {{ $selectedId == $o->$oKey ? 'selected' : '' }}>{{ $o->$oValue }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
</div>