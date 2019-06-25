<h2 class="card-inside-title">Текст</h2>
<div class="language_interface">
    @if(isset($allLang) || !empty($allLang))
        @foreach($allLang as $value)
            <h2 class="card-inside-title">{{$value->title}}</h2>
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control text-editor-eurotransit" name="data[set_lang][{{$value->url}}]">
                                <?php if(!empty($item)) {
                                    foreach((array)json_decode($item->data) as $array) {
                                        foreach ($array as $lang=>$i) {
                                            if($lang == $value->url) {
                                                echo $i;
                                            }
                                        }
                                    }
                                }?>
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <textarea class="form-control editor-eurotransit" name="data"><?php empty($item) ? '' : $item ?></textarea>
    @endif
</div>
