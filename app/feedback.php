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
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
</head>
<body>
    <nav>
        <a href="<?php echo ROOT_URL; ?>"><img class="subLogo" src="<?php echo IMAGE.'subLogo.png'; ?>"></a>
    </nav>
    <section>
        <div class="form">
            <!-- <h1>サイトへのご意見・ご感想などご自由に投稿してください。</h1><br><br><br> -->
            <form action="<?php echo FEEDBACK_CONFIRM ?>" method="POST">
                <table>
                    <tr>
                        <td class="col_formName">お名前:　</td>
                        <td><input class="col_form" size="40" type="text" name="name" value="<?php echo form_value('name'); ?>"></td>
                    </tr>
                    <tr>
                        <td>　</td>
                        <td>　</td>
                    </tr>
                    <tr>
                        <td class="col_formName" font-size="10px">メールアドレス:　</td>
                        <td><input class="col_form" size="50" type="text" name="mailAddress" value="<?php echo form_value('mailAddress'); ?>"></td>
                    </tr>
                    <tr>
                        <td>　</td>
                        <td>　</td>
                    </tr>
                    <tr>
                        <td class="col_formName" font-size="10px">メールアドレス(確認用):　</td>
                        <td><input class="col_form" size="50" type="text" name="mailAddress_conf" value="<?php echo form_value('mailAddress_conf'); ?>"></td>
                    </tr>
                    <tr>
                        <td>　</td>
                        <td>　</td>
                    </tr>
                    </tr>
                        <td class="col_formName content" font-size="10px">内容:　</td>
                        <td><textarea vertical-align="bottom" class="col_form" name="feedbackContent"><?php echo form_value('feedbackContent'); ?></textarea></td>
                    </tr>
                </table>
                <br>
                <!-- 投稿画面から投稿確認画面へ遷移したことを示すフラグを渡す -->
                <input type="hidden" name="mode" value="FEEDBACK_CONFIRM">
                <input class="button" type="submit" value="内容の確認へ">
            </form>
        </div>
    </section>
    <footer>
        
    </footer>
</body>
</html>