<?php

class Image{
    public static function getFrom64($image_data){
        list($type, $data) = explode(';', $image_data);
        list(, $data)      = explode(',', $data);

        return array('type' => $type, 'extension' => substr($type, strpos($type, '/')+1), 'data' => $data);
    }

    public static function store64($image, $name, $location = 'recipe_images'){
        $path = public_path() . '/' . $location . '/' . $name;
        file_put_contents($path, base64_decode($image));
    }
}