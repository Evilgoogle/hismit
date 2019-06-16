<h2 class="card-inside-title">{{ $label }} {{ isset($required) && $required ? '*' : '' }}</h2>
<div class="row clearfix">
    <div class="col-sm-12">
        <div class="form-group">
            <div class="form-line">
                @if (!empty($item))
                    @if (isset($array) && $array && !empty($item))
                        <?php $name_new = substr($name, 0, -1) ?>
                        <table class="order-table images-table">
                            <tbody>
                            @foreach($item as $i)
                                <tr id="{{ $i->id }}">
                                    <td class="index">{{ $i->position }}</td>
                                    <td>
                                        <div class="thumbnail" id="{{ $i->id }}" data-model="{{ $modelName }}" data-column="{{ $name_new }}" data-remove="1">
                                            <a href="{{ asset('uploads/'. $i->$name_new) }}" target="_blank">
                                                @if (isset($is_image) && $is_image)
                                                    <img src="{{ asset('uploads/'. $i->$name_new) }}" class="img-responsive">
                                                @else
                                                    {{ $i->$name_new }}
                                                @endif
                                            </a>
                                            <button type="button" title="Удалить" class="btn btn-danger removeButton removeImage btn-xs">Удалить</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @elseif (!empty($item->$name))
                        <div class="thumbnail" id="{{ $item->id }}" data-model="{{ $modelName }}" data-column="{{ $name }}" data-remove="0">
                            <a href="{{ asset('uploads/'. $item->$name) }}" target="_blank">
                                @if (isset($is_image) && $is_image)
                                    <img src="{{ asset('uploads/'. $item->$name) }}" class="img-responsive">
                                @else
                                    {{ $item->$name }}
                                @endif
                            </a>
                            <button type="button" title="Удалить" class="btn btn-danger removeButton removeImage btn-xs">Удалить</button>
                        </div>
                    @endif
                @endif
                <input
                    class="form-control"
                    type="file"
                    id="{{ $name }}"
                    name="{{ $name }}{{ isset($array) && $array ? '[]' : '' }}"
                    {{ isset($required) && empty($item) && $required ? 'required' : '' }}
                    {{ isset($array) && $array ? 'multiple' : '' }}
                    {{ isset($disabled) && $disabled ? 'disabled' : '' }}>
            </div>
        </div>
    </div>
</div>
