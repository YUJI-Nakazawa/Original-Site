<?php

//JSONのURL
$url = "/Applications/MAMP/htdocs/originalSite/json/KimonoData_dw6eu19k.json";
//JSONの読み込み
$json = file_get_contents($url);
// echo $json;
// JSONの文字化け防止
// $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
//JSONを連想配列にデコード
$arr = json_decode($json, true);

var_dump($arr);











?>