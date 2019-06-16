<?php
foreach ($land_data as $value) { $url = $value->url;?>
    <div class="langActive_insert <?php if($lang->default_lang == $value->url) {?> active_insert <?php }?> js_lang_<?php echo $value->url ?>">
        <h2 class="card-inside-title"><?php echo $this->sets['label'] ?></h2>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <!-- Проверка type. По переданному значению подключается нужный шаблон -->
                        <?php if(isset($this->sets['type'])) {
                            if($this->sets['type'] == 'input') {?>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="<?php echo $this->sets['name'] ?>"
                                    name="<?php echo $this->sets['name'].'['.$value->url.']' ?>"
                                    placeholder="<?php echo $this->sets['label'] ?>"
                                    value="<?php echo isset($this->item->$url) ? $this->item->$url : '' ?>">
                            <?php } elseif ($this->sets['type'] == 'textarea') {?>
                                <textarea
                                    class="form-control <?php echo isset($this->sets['editor']) && $this->sets['editor'] ? 'text-editor' : '' ?>"
                                    id="<?php echo $this->sets['name'] ?>"
                                    name="<?php echo $this->sets['name'] ?>"
                                    placeholder="<?php echo $this->sets['label'] ?>"
                                    <?php if (isset($this->sets['editor']) && $this->sets['editor']) {
                                        echo isset($this->sets['name']) ? $this->sets['name'] : '';
                                    }?>
                                ><?php echo isset($this->item->$url) ? $this->item->$url : '' ?></textarea>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }