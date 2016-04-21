<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>素材データ登録画面</title>
</head>
<body>
    <form action="admin_sourceInsert.php" method="post" enctype="multipart/form-data">
        素材ファイル：<br>
        <input type="file" name="source_file" size="30"><br>
        <br>
        <input type="submit" value="アップロード">
    </form>
    <button id="clear">ファイル選択をクリア</button>
    <script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script src="../js/clear.js"></script>
</body>
</html>