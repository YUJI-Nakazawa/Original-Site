<?php 

//DBへの接続を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MuchaBuri_db(){
    try{
        $pdo = new PDO('mysql:host=localhost; dbname=MuchaBuri; charset=utf8','root','root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $connect_e) {
        die('DB接続に失敗しました。次記のエラーにより処理を中断します:'.$connect_e->getMessage());
    }
}

//sourceテーブルにレコードの挿入を行うメソッド。失敗した場合はエラー文を返却する
function insertSOURCE($url, $comment, $typeID, $expression, $imgFeature){
    //DB接続を確立
    $insertSOURCE_db = connect2MuchaBuri_db();
    //sourceテーブルにレコードを挿入するSQL
    $insertSOURCE_sql = "INSERT INTO source(url, comment, typeID, expression, imgFeature, insertedDate)"
            . "VALUES(:url, :comment, :typeID, :expression, :imgFeature, :insertedDate)";
    //現在時をdatetime型で取得
    $datetime = new DateTime();
    $insertedDate = $datetime->format('Y-m-d');
    //クエリとして用意
    $insertSOURCE_query = $insertSOURCE_db->prepare($insertSOURCE_sql);
    //SQL文に値＆現在時をバインド
    $insertSOURCE_query->bindValue(':url', $url);
    $insertSOURCE_query->bindValue(':comment', $comment);
    $insertSOURCE_query->bindValue(':typeID', $typeID);
    $insertSOURCE_query->bindValue(':expression', $expression);
    $insertSOURCE_query->bindValue(':imgFeature', $imgFeature);
    $insertSOURCE_query->bindValue(':insertedDate', $insertedDate);
    //SQLを実行
    try{
        $insertSOURCE_query->execute();
    } catch (PDOException $insertSOURCE_e) {
        //接続オブジェクトを初期化することでDB接続を切断
        return $insertSOURCE_e->getMessage();
    }
    $insertSOURCE_db=null;
    return null;
}

//sourceテーブルから条件にあるレコードを選択する
function selectSOURCE($typeID, $expression){
    //DB接続を確立
    $selectSOURCE_db = connect2MuchaBuri_db();
    //sourceテーブルから条件にあうレコードのimgFeatureを検索するSQL文
    // $select_source_sql = "SELECT imgFeature FROM source WHERE typeID = :typeID CASE WHEN typeID = 1 THEN AND expression LIKE :expression";
    // $select_source_sql = "SELECT imgFeature FROM source WHERE (typeID = :typeID) AND expression LIKE :expression";
    $selectSOURCE_sql = "SELECT comment, imgFeature FROM source WHERE typeID = :typeID";
    //クエリとして用意
    $selectSOURCE_query = $selectSOURCE_db->prepare($selectSOURCE_sql);
    //SQL文に値をバインド
    $selectSOURCE_query->bindValue(':typeID', $typeID);
    // $select_source_query->bindValue(':expression', '%'.$expression.'%');
    //SQLを実行
    try{
        $selectSOURCE_query->execute();
    } catch (PDOException $selectSOURCE_e) {
        //接続オブジェクトを初期化することでDB接続を切断
        return $selectSOURCE_e->getMessage();
    }
    return $selectSOURCE_query->fetchAll(PDO::FETCH_ASSOC);
    // return $selectSOURCE_query->fetchAll(PDO::FETCH_COLUMN);
    $insertSOURCE_db = null;
}

//feedbackテーブルにレコードの挿入を行うメソッド。失敗した場合はエラー文を返却する
function insertFeedback($name, $mailAddress, $feedbackContent){
    //DB接続を確立
    $insertFeedback_db = connect2MuchaBuri_db();
    //sourceテーブルにレコードを挿入するSQL
    $insertFeedback_sql = "INSERT INTO feedback(name, mailAddress, feedbackContent, postedDateTime)"
            . "VALUES(:name, :mailAddress, :feedbackContent, :postedDateTime)";
    //現在時をdatetime型で取得
    $datetime = new DateTime();
    $postedDateTime = $datetime->format('Y-m-d H:i:s');
    //クエリとして用意
    $insertFeedback_query = $insertFeedback_db->prepare($insertFeedback_sql);
    //SQL文に値＆現在時をバインド
    $insertFeedback_query->bindValue(':name', $name);
    $insertFeedback_query->bindValue(':mailAddress', $mailAddress);
    $insertFeedback_query->bindValue(':feedbackContent', $feedbackContent);
    $insertFeedback_query->bindValue(':postedDateTime', $postedDateTime);
    //SQLを実行
    try{
        $insertFeedback_query->execute();
    } catch (PDOException $insertFeedback_e) {
        //接続オブジェクトを初期化することでDB接続を切断
        return $insertFeedback_e->getMessage();
    }
    $insertFeedback_db=null;
    return null;
}


 ?>