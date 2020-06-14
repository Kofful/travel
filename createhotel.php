<?php
if (isset($_FILES)) {
    $result = "";
    foreach ($_FILES as $file) {
//        $uploaddir = 'D:/OSPanel/domains/mandrivka/images/';
//        $filename = basename(str_replace(" ", "", str_replace(".", "", microtime())) . "." . explode("/", $file['type'])[1]);
//        $uploadfile = $uploaddir . $filename;
//        move_uploaded_file($file['tmp_name'], $uploadfile);
//        $img = file($uploadfile);
//        $width = imagesx($img);
//        $height = imagesy($img);
//        $centreX = round($img->getWidth() / 2);
//        $centreY = round($img->getHeight() / 2);
//
//        $x1 = $centreX - 300;
//        $y1 = $centreY - 200;
//
//        $x2 = $centreX + 300;
//        $y2 = $centreY + 200;
//
//        $img->crop($x1, $y1, $x2, $y2);
//        $result .= file_get_contents($img);
//        $result .= " ";
    }
    echo $result;

}