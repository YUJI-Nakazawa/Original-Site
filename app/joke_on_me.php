<?php 
require_once '../util/defineUtil.php';
require_once '../util/classUtil.php';
?>

 <!DOCTYPE html>
 <html>
 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <title>Mucha Buri 実行</title>
 </head>
 <body>
     <?php 
     $image_file = !empty( $_FILES["image_file"]["tmp_name"] ) ? $_FILES["image_file"]["tmp_name"] : null;
     if( empty($image_file) ){
        echo 'ファイルが選択されておりません。<br>';
     }
     else{
         $MUCHA_BURI = new MUCHA_BURI();
         $MUCHA_BURI -> setIMAGE($image_file);
         $MUCHA_BURI -> searchIMAGE();
     } ?>
     <a href="<?php echo ROOT_URL; ?>">TOP</a>
     <a href="<?php ?>"></a>
 </body>
 </html>