<?php
session_start();
require_once '../util/defineUtil.php';
require_once '../util/dbaccessUtil.php';
require_once '../util/scriptUtil.php';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
      <title>投稿結果画面</title>
</head>
<nav>
    <a href="<?php echo ROOT_URL; ?>">TOP</a>
</nav>
<body>
<?php
//投稿確認画面から「送信」ボタンを押した場合のみ処理を行う
$mode = isset($_POST['mode']) ? $_POST['mode'] : "";
if($mode != "FEEDBACK_RESULT"){
    echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
}else{
    $name = $_SESSION['name'];
    $mailAddress = $_SESSION['mailAddress'];
    $feedbackContent = $_SESSION['feedbackContent'];

    //DBのfeedbackテーブルへの挿入処理。エラーの場合のみエラー文がセットされる。成功すればnull
    $insertFeedback_result = insertFeedback($name, $mailAddress, $feedbackContent);

    //テーブルへの挿入にエラーがなかったら実行
    if(!isset($insertFeedback_result)){
    ?>
        名前:<?php echo $name;?><br>
        メールアドレス:<?php echo $mailAddress;?><br>
        内容:<?php echo $feedbackContent;?><br>
        <?php
        // セッションのクリア
        unset($_SESSION['name']);
        unset($_SESSION['mailAddress']);
        unset($_SESSION['mailAddress_conf']);
        unset($_SESSION['feedbackContent']);
    }
    else{
        echo 'データの挿入に失敗しました。次記のエラーにより処理を中断します:'.$insertFeedback_result;
    }
}
?>
</body>
</html>
