<?php 
session_start();
require_once '../util/defineUtil.php';
require_once '../util/scriptUtil.php';
require_once '../util/classUtil.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
      <title>Feedback</title>
</head>
<nav>
    <a href="<?php echo ROOT_URL; ?>">TOP</a>
</nav>
<body>
    <?php
    //投稿画面から「内容の確認へ」ボタンを押した場合のみ処理を行う
    $mode = isset($_POST['mode']) ? $_POST['mode'] : "";
    if($mode != "FEEDBACK_CONFIRM"){
        echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
    }else{
        //ポストの存在チェックとセッションに値を格納しつつ、連想配列にポストされた値を格納
        $confirmValue_array = array(
                                'name' => bind_p2s('name'),
                                'mailAddress' => bind_p2s('mailAddress'),
                                'mailAddress_conf' => bind_p2s('mailAddress_conf'),
                                'feedbackContent' => bind_p2s('feedbackContent'));
        //未入力項目があるか判別
        if( !in_array(null, $confirmValue_array, true) && !in_array("", $confirmValue_array, true)){
            //メールアドレスが確認用メールアドレスと合っているか判別
            if($confirmValue_array['mailAddress'] == $confirmValue_array['mailAddress_conf']){
                   $input_check = true; //未入力項目がなく、メールアドレスも合っていればtrue
                   ?>
                   名前:<?php echo $confirmValue_array['name'];?><br>
                   メールアドレス:<?php echo $confirmValue_array['mailAddress'];?><br>
                   内容:<?php echo $confirmValue_array['feedbackContent'];?><br>

                   <form action="<?php echo FEEDBACK_RESULT ?>" method="POST">
                       <!-- 投稿確認画面から投稿結果画面へ遷移したことを示すフラグを渡す -->
                       <input type="hidden" name="mode" value="FEEDBACK_RESULT" >
                       <input type="submit" value="送信">
                   </form>
                   <?php
            }
        }
        //未入力項目があるときに以下の処理をする
        else {
            $input_check = false;
            ?>
            <h1>入力項目が不完全です</h1><br>
            再度入力を行ってください<br>
            <h3>不完全な項目</h3>
            <?php
            //連想配列内の未入力項目を検出して表示
            foreach ($confirmValue_array as $key => $value){
                if( $value == null || $value == ""){
                    if($key == 'name'){
                        echo '名前';
                    }
                    if($key == 'mailAddress'){
                        echo 'メールアドレス';
                    }
                    if($key == 'mailAddress_conf'){
                        echo 'メールアドレス(確認用)';
                    }
                    if($key == 'feedbackContent'){
                        echo '内容';
                    }
                    echo 'が未入力です<br>';
                }
            }
        }
        //メールアドレスが確認用と異なる場合NGとする。
        if($confirmValue_array['mailAddress'] != $confirmValue_array['mailAddress_conf']){
            $input_check = false;
            echo 'メールアドレスの入力に誤りがあります。';
        }
        ?>
        <form action="<?php echo FEEDBACK ?>" method="POST">
            <!-- 投稿確認画面から投稿画面へ遷移したことを示すフラグを渡す -->
            <input type="hidden" name="mode" value="REINPUT" >
            <input type="submit" name="no" value="戻る">
        </form>
        <?php 
    }?>
</body>
</html>