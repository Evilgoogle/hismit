<?php
namespace App\EmotionsGroup\Basic;

class Uploader  {
    private $folder;
    private $model;
    private $field;
    private $createname = '';
    private $filename;
    private $base64_file;
    public $rootUpload = 'uploads';
    public $minwidth = 10;
    public $minheight = 10;
    public $resize_width = 100;
    public $base64_type;
    public $new_width;
    public $new_height;
    public $filesize;
    public $quality_jpg = 95;
    public $quality_png = 8;

    public function __construct($model = 'pic') {
        $this->model = $model;
    }

    private function setError($error) {
        @unlink($this->base64_file);
        throw new \Exception(htmlspecialchars($this->field).'. '.$error);
    }

    private function Validation($file, $size = false) {
        if(!file_exists($file)) {
            $this->setError('Не найдено изображение');
            return false;
        } else {
            $filesize = filesize($file);
            if($filesize < 500) {
                $this->setError('Размер изображение слишком мал');
                return false;
            } elseif($filesize > 50000000) {
                $this->setError('Размер изображение слишком большой');
                return false;
            }

            if(!$size) {
                $image = getimagesize($file);
                if($image[0] < $this->minwidth) {
                    $this->setError('Ширина изображение слишком мала. Минимальные требования '.$this->minwidth.' px');
                    return false;
                } elseif($image[1] < $this->minheight) {
                    $this->setError('Высота изображение слишком мала. Минимальные требования '.$this->minheight.' px');
                    return false;
                }
            }
            return true;
        }
    }

    public function generateFileName($file, $name, $type = 'jpg') {
        if(empty($name)) {
            $tmp = date('U').md5(str_random(10).time()).'.'.$type;
        } else {
            $tmp = $name.'.'.$type;
        }
        $this->filename = $this->model.$tmp;
        return true;
    }

    public function base64_creator($file) {

        $random = str_random(10).time();
        $temp = $this->folder.'temp_'.$this->model.'_'.$random;
        $type = '.jpg';

        $get = explode(',', $file);
        if($get[0] == 'data:image/jpeg;base64') {

            $create = fopen($temp.'.jpg', "w");
            $type = '.jpg';
        } elseif($get[0] == 'data:image/png;base64') {

            $create = fopen($temp.'.png', "w");
            $type = '.png';
        } elseif($get[0] == 'data:image/gif;base64') {

            $create = fopen($temp.'.gif', "w");
            $type = '.gif';
        } elseif($get[0] == 'data:image/svg+xml;base64') {

            $create = fopen($temp.'.svg', "w");
            $type = '.svg';
        }

        fwrite($create, base64_decode($get[1]));
        fclose($create);

        $this->base64_file = $temp.$type;
        $this->base64_type = $get[0];
        return $temp.$type;
    }

    public function cropUpload($key ,$value, $resize = false) {

        $this->folder = public_path($this->rootUpload).'/';
        $random = str_random(10).time();

        $create = fopen($this->folder.'\temp_'.$key.'_'.$random.'.jpg', "w");
        $get = explode(',', $value);
        fwrite($create, base64_decode($get[1]));
        fclose($create);

        $file = $this->folder.'\temp_'.$key.'_'.$random.'.jpg';
        $this->field = $key;

        if($this->Validation($file)) {
            $image = getimagesize($file);

            // Пропорциональное уменьшение размера картины, если активирован resize
            if($resize) {
                $resize_width = $this->resize_width;
                $resize_height = $image[1]/($image[0]/$this->resize_width);
            } else {
                $resize_width = $image[0];
                $resize_height = $image[1];
            }
            
            $thumb = imagecreatetruecolor($resize_width, $resize_height);
            if(preg_match('#image/jpeg#ui', $get[0])) {
                $this->generateFileName($file, $this->createname, 'jpg');

                $filed = imagecreatefromjpeg($file);
                
                imagecopyresampled($thumb, $filed, 0, 0, 0, 0, $resize_width, $resize_height, $image[0], $image[1]);
                imagejpeg($thumb, $this->folder.'/'.$this->filename, $this->quality_jpg);
            } elseif(preg_match('#image/png#ui', $get[0])) {
                $this->generateFileName($file, $this->createname, 'png');

                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);

                $filed = imagecreatefrompng($file);
                imagecopyresampled($thumb, $filed, 0, 0, 0, 0, $resize_width, $resize_height, $image[0], $image[1]);
                imagepng($thumb, $this->folder.'/'.$this->filename, $this->quality_png);
            }
            imagedestroy($thumb);

            unlink($file);
            return $this->filename;
        }

    }

    public function filemanagerUpload($file, $resize = false, $filename = false) {

        $size = false; // size - указывает то файл без размера. Векторный файл
        $test_svg = explode(',', $file);
        if($test_svg[0] == 'data:image/svg+xml;base64') {
            $size = true;
        }

        // Создание временного файла в из base64
        $this->folder = public_path($this->rootUpload).'/';
        $file = $this->base64_creator($file);

        // проверка и обработка
        if($this->Validation($file, $size)) {

            if($size) {

                /* --> Обработка SVG файла */
                $this->generateFileName($file, $this->createname, 'svg');
                if(!copy($file, $this->folder.$this->filename)) {
                    $this->setError('Не удалось загрузить SVG файл');
                }

                @unlink($this->base64_file);
            } else {

                 /* --> Обработка обычных jpg png gif файлов */
                $image = getimagesize($file);

                // Пропорциональное уменьшение размера картины, если активирован resize
                if($resize) {
                    $this->new_width = $this->resize_width;
                    $this->new_height = $image[1]/($image[0]/$this->resize_width);
                } else {
                    $this->new_width = $image[0];
                    $this->new_height = $image[1];
                }

                $thumb = imagecreatetruecolor($this->new_width, $this->new_height);
                if($image['mime'] == 'image/jpeg' || $image['mime'] == 'image/jpg') {

                    if($filename !== false) {
                        $this->filename = $filename;
                    } else {
                        $this->generateFileName($file, $this->createname, 'jpg');
                    }

                    $filed = imagecreatefromjpeg($file);

                    imagecopyresampled($thumb, $filed, 0, 0, 0, 0, $this->new_width, $this->new_height, $image[0], $image[1]);
                    imagejpeg($thumb, $this->folder.$this->filename, $this->quality_jpg);
                } elseif($image['mime'] == 'image/png') {

                    if($filename !== false) {
                        $this->filename = $filename;
                    } else {
                        $this->generateFileName($file, $this->createname, 'png');
                    }

                    imagealphablending($thumb, false);
                    imagesavealpha($thumb, true);

                    $filed = imagecreatefrompng($file);
                    imagecopyresampled($thumb, $filed, 0, 0, 0, 0, $this->new_width, $this->new_height, $image[0], $image[1]);
                    imagepng($thumb, $this->folder.$this->filename, $this->quality_png);
                } elseif($image['mime'] == 'image/gif') {

                    // Анимация пока не работает. Надо сделать
                    if($filename !== false) {
                        $this->filename = $filename;
                    } else {
                        $this->generateFileName($file, $this->createname, 'gif');
                    }

                    imagealphablending($thumb, false);
                    imagesavealpha($thumb, true);

                    $filed = imagecreatefromgif($file);
                    imagecopyresampled($thumb, $filed, 0, 0, 0, 0, $this->new_width, $this->new_height, $image[0], $image[1]);
                    imagegif($thumb, $this->folder.$this->filename);
                }
                imagedestroy($thumb);
            }

            $this->filesize = filesize($this->folder.$this->filename);
            @unlink($this->base64_file);

            return $this->filename;
        }
    }

    public function upload($file, $resize = false) {

        $this->field = 'Изображение';
        if(!in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            $this->setError('Загружать можно только: jpg, jpeg, png и gif');
        }

        if($this->Validation($file->path())) {
            $image = getimagesize($file->path());

            // Пропорциональное уменьшение размера картины, если активирован resize
            if($resize) {
                $resize_width = $this->resize_width;
                $resize_height = $image[1]/($image[0]/$this->resize_width);
            } else {
                $resize_width = $image[0];
                $resize_height = $image[1];
            }

            $thumb = imagecreatetruecolor($resize_width, $resize_height);
            if(in_array($file->extension(), ['jpg', 'jpeg'])) {

                $this->generateFileName('jpg');
                $filed = imagecreatefromjpeg($file->path());

                imagecopyresampled($thumb, $filed, 0, 0, 0, 0, $resize_width, $resize_height, $image[0], $image[1]);
                imagejpeg($thumb, $this->folder.'/'.$this->filename, $this->quality_jpg);
            } elseif(in_array($file->extension(), ['png'])) {

                $this->generateFileName('png');
                $filed = imagecreatefrompng($file->path());

                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);

                imagecopyresampled($thumb, $filed, 0, 0, 0, 0, $resize_width, $resize_height, $image[0], $image[1]);
                imagepng($thumb, $this->folder.'/'.$this->filename, $this->quality_png);
            } elseif(in_array($file->extension(), ['gif'])) {

                $this->generateFileName('gif');
                $filed = imagecreatefromgif($file->path());

                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);

                imagecopyresampled($thumb, $filed, 0, 0, 0, 0, $this->new_width, $this->new_height, $image[0], $image[1]);
                imagegif($thumb, $this->folder.$this->filename);
            }
            imagedestroy($thumb);

            unlink($file->path());
            return $this->filename;
        }
    }

    public function uploadFile($file, $resize = false) {

        $this->field = 'Файл';
        if(!in_array($file->extension(), ['doc', 'docx', 'pdf', 'jpg'])) {
            $this->setError('Загружать можно только: doc, docx, pdf и jpg');
        }

        $file_extension = strtolower($file->getClientOriginalExtension());
        $file_name = md5(str_random(10) . time()) . '.' . $file_extension;

        $file->move('uploads', $file_name);
        return $file_name;
    }
}