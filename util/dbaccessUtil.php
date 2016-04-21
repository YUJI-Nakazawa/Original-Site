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
    $insert_source_db = connect2MuchaBuri_db();
    //sourceテーブルにレコードを挿入するSQL
    $insert_source_sql = "INSERT INTO source(url, comment, typeID, expression, imgFeature, insertedDate)"
            . "VALUES(:url, :comment, :typeID, :expression, :imgFeature, :insertedDate)";
    //現在時をdatetime型で取得
    $datetime = new DateTime();
    $insertedDate = $datetime->format('Y-m-d');
    //クエリとして用意
    $insert_source_query = $insert_source_db->prepare($insert_source_sql);
    //SQL文に値＆現在時をバインド
    $insert_source_query->bindValue(':url', $url);
    $insert_source_query->bindValue(':comment', $comment);
    $insert_source_query->bindValue(':typeID', $typeID);
    $insert_source_query->bindValue(':expression', $expression);
    $insert_source_query->bindValue(':imgFeature', $imgFeature);
    $insert_source_query->bindValue(':insertedDate', $insertedDate);
    //SQLを実行
    try{
        $insert_source_query->execute();
    } catch (PDOException $insert_source_e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_source_db=null;
        return $insert_source_e->getMessage();
    }

    $insert_source_db=null;
    return null;
}

//sourceテーブルから条件にあるレコードを選択する
function selectSOURCE($typeID, $expression){
    //DB接続を確立
    $select_source_db = connect2MuchaBuri_db();
    //sourceテーブルから条件にあうレコードのimgFeatureを検索するSQL文
    // $select_source_sql = "SELECT imgFeature FROM source WHERE typeID = :typeID CASE WHEN typeID = 1 THEN AND expression LIKE :expression";
    // $select_source_sql = "SELECT imgFeature FROM source WHERE (typeID = :typeID) AND expression LIKE :expression";
    $select_source_sql = "SELECT imgFeature FROM source WHERE typeID = :typeID";
    //クエリとして用意
    $select_source_query = $select_source_db->prepare($select_source_sql);
    //SQL文に値をバインド
    $select_source_query->bindValue(':typeID', $typeID);
    // $select_source_query->bindValue(':expression', '%'.$expression.'%');
    //SQLを実行
    try{
        $select_source_query->execute();
    } catch (PDOException $select_source_e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $select_source_db = null;
        return $select_source_e->getMessage();
    }
    return $select_source_query->fetchAll(PDO::FETCH_COLUMN);
    $insert_source_db = null;
}




 ?>