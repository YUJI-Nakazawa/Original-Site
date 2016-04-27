<?php 
require_once '../util/defineUtil.php';
require_once '../util/classUtil.php';
?>

 <!DOCTYPE html>
 <html>
 <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <link rel="stylesheet" type="text/css" href="../css/style.css"/>
     <title>Joke On You | Mucha Buri</title>
 </head>
 <body>
     <nav>
         <a href="<?php echo ROOT_URL; ?>"><img class="subLogo" src="<?php echo IMAGE.'subLogo.png'; ?>"></a>
         <a class="navFont" href="<?php echo FEEDBACK ?>">Feedback</a>
     </nav>
     <section>
     <?php 
     $image_file = !empty( $_FILES["image_file"]["tmp_name"] ) ? $_FILES["image_file"]["tmp_name"] : null;
     //アップロードされた画像の保存名
     $uploaded_image_name = UPLOADED_IMAGE.'/'.date('YmdHis').'.jpg';
     //アップロードされた画像を指定したディレクトリに保存
     move_uploaded_file($image_file, $uploaded_image_name);
     if( empty($image_file) ){?>
        <div>
            <br><br><br>
            <h1>ファイルが選択されておりません!</h1><br><br><br><br><br>
            <a href="<?php echo ROOT_URL; ?>"> ←Back</a>
        </div> 
     <?php }
     else{
         $MUCHA_BURI = new MUCHA_BURI();
         $MUCHA_BURI -> setIMAGE($uploaded_image_name); // → メソッド内でfile_get_contentsして画像認識実施
         $MUCHA_BURI_result = $MUCHA_BURI -> searchIMAGE();
         ?>
         <div class="boke">
             <img src="<?php echo $uploaded_image_name; ?>" width="500" height="auto">
             <h2><?php echo $MUCHA_BURI_result[1]; ?></h2><br>
             <!-- <h2>テストボケ</h2><br> -->
              <a href="https://twitter.com/share" class="twitter-share-button" data-via="sleepingcat1025" data-size="large">Tweet</a>
              <script>
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
              </script>
         </div>
         <?php
        //  if( count(glob(UPLOADED_IMAGE.'*')) >= 3 ){
        //      echo count( glob(UPLOADED_IMAGE.'*') );
        //      unlink( UPLOADED_IMAGE.'*' );
        //  }
     } ?> 
    </section>
     <footer>
         
     </footer>
 </body>
 </html>