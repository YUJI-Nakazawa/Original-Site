<?php 
require_once '../util/defineUtil.php';
require_once '../util/classUtil.php';
?>

 <!DOCTYPE html>
 <html>
 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <title>素材データ登録完了</title>
 </head>
 <body>
     <?php 
     $source_file = !empty( $_FILES["source_file"]["tmp_name"] ) ? $_FILES["source_file"]["tmp_name"] : null;
     if( empty($source_file) ){
        echo 'ファイルが選択されておりません。<br>';
     }
     else{
         $sourceHandle = new SOURCE();
         $sourceHandle -> setSOURCE($source_file);
     ?>
     <h3><?php echo $sourceHandle -> saveSOURCE(); ?></h3>
     <?php } ?>
     <a href="<?php echo ADMIN_SOURCE_UPLOAD; ?>">素材データ登録画面へ</a>
     <a href="<?php ?>"></a>
 </body>
 </html>