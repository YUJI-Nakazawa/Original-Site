<?php 
// 顔検出
$face = array(
    "type" => "FACE_DETECTION" ,
    "maxResults" => 3 ,
);
//ランドマークの認識
$landmark = array(
    "type" => "LANDMARK_DETECTION" ,
    "maxResults" => 3 ,
);
//ロゴの検出
$logo = array(
    "type" => "LOGO_DETECTION" ,
    "maxResults" => 3 ,
);
//カテゴリの検出
$label = array(
    "type" => "LABEL_DETECTION" ,
    "maxResults" => 3 ,
);
//OCR 文字の検出
$text = array(
    "type" => "TEXT_DETECTION" ,
    "maxResults" => 3 ,
);
//セーフサーチ
$safe_search = array(
    "type" => "SAFE_SEARCH_DETECTION" ,
    "maxResults" => 3 ,
);
//画像に関する色データを検出
$image_properties = array(
    "type" => "IMAGE_PROPERTIES" ,
    "maxResults" => 3 ,
);


 ?>