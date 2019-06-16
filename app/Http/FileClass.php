<?php

namespace App\Http;

class FileClass
{
    private $rootUpload;

    public function __construct()
    {
        $this->rootUpload = public_path('uploads');
    }

    public function putFile($file, $field_name, $item, $is_array = false, $upload_url = null)
    {
        if ($is_array)
            $field_name = substr($field_name,0,-1);
        if (!empty($upload_url))
            $this->rootUpload = public_path('uploads/'.$upload_url);

        $file_extension = strtolower($file->getClientOriginalExtension());
        $file_name = md5(str_random(10) . time()) . '.' . $file_extension;
        $file->move($this->rootUpload, $file_name);

        return $item->$field_name = $file_name;
    }

    public function uploadFile($file)
    {
        $file_extension = strtolower($file->getClientOriginalExtension());
        $file_name = md5(str_random(10) . time()) . '.' . $file_extension;
        $file->move($this->rootUpload, $file_name);

        return $file_name;
    }

    public function copyFile($file_name, $field_name, $item)
    {
        $file_extension = pathinfo($this->rootUpload . '/' . $file_name)['extension'];
        $new_file_name = md5(str_random(10) . time()) . '.' . $file_extension;
        copy($this->rootUpload . '/' . $file_name, $this->rootUpload . '/' . $new_file_name);

        return $item->$field_name = $new_file_name;
    }

    public function putFileUrl($file, $field_name, $item)
    {
        $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $file_name = md5(str_random(10) . time()) . '.' . $file_extension;
        $file_upload = file_get_contents($file);
        file_put_contents($this->rootUpload . '/' . $file_name, $file_upload);

        return $item->$field_name = $file_name;
    }

    public function removeFile($image_name)
    {
        $old_image = $image_name;
        if (!empty($old_image)) {
            if (file_exists($this->rootUpload . '/' . $old_image)) {
                unlink($this->rootUpload . '/' . $old_image);
            }
        }
    }
}