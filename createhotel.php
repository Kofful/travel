<?php
if (isset($_FILES)) {
    $result = "";
    foreach ($_FILES as $file) {
        $uploaddir = 'D:/OSPanel/domains/mandrivka/images/';
        $filename = basename(str_replace(" ", "", str_replace(".", "", microtime())) . "." . explode("/", $file['type'])[1]);
        $uploadfile = $uploaddir . $filename;
        move_uploaded_file($file['tmp_name'], $uploadfile);
        $img = imagecreatefromjpeg($uploadfile);
        $width = imagesx($img);
        $height = imagesy($img);
        if($width / $height < 1.5) {
            $new_height = round($width / 1.5);
            $img = imagecrop($img, ['x' => 0, 'y' => round(($height - $new_height) / 2), 'width' => $width, 'height' => $new_height]);
        } else {
            $new_width = round($height * 1.5);
            $img = imagecrop($img, ['x' => round(($width - $new_width) / 2), 'y' => 0, 'width' => $new_width, 'height' => $height]);
        }
        imagejpeg($img, $uploadfile);
        $result .= base64_encode(file_get_contents($uploadfile));
        $result .= " ";
        imagedestroy($img);
        unlink($uploadfile);
    }
    echo $result;

}