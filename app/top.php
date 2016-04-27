<?php 
require_once '../util/defineUtil.php';
require_once '../util/scriptUtil.php';
require_once '../util/classUtil.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <title>TOP | Mucha Buri</title>
</head>
<body>
    <nav>
        <a href="<?php echo ROOT_URL; ?>"><img class="subLogo" src="<?php echo IMAGE.'subLogo.png'; ?>"></a>
        <a class="navFont" href="<?php echo FEEDBACK; ?>">Feedback</a>
    </nav>
    <section>
        <div>
            <img class="mainLogo" src="<?php echo IMAGE.'mainLogo.png'; ?>">
            <form action="<?php echo JOKE_ON_ME; ?>" method="post" enctype="multipart/form-data">
                <input type="file" name="image_file" size="30"><br>
                <br>
                <input type="submit" value="Mucha Buru">
            </form>
            <!-- <button id="clear">ファイル選択をクリア</button> -->
            <!-- <script src="http://code.jquery.com/jquery-2.2.0.min.js"></script> -->
            <!-- <script src="../js/clear.js"></script> --> 
        </div>
    </section>
    <footer>
        
    </footer>
</body>
</html>