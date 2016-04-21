<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ネタ画像投稿画面</title>
</head>
<body>
    <h1>Mucha Buri</h1>
    <h5>-jokes on you-</h5>
    <form action="joke_on_me.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image_file" size="30"><br>
        <br>
        <input type="submit" value="アップロード">
    </form>
    <button id="clear">ファイル選択をクリア</button>
    <script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script src="../js/clear.js"></script>
</body>
</html>