<?php 

require_once 'defineUtil.php';

function CLOUD_VISON_API($image_path){
    require 'featuresUtil.php';
    // リファラー (許可するリファラーを設定した場合)
    // $referer = "https://...com/" ;
    // リクエスト用のJSONを作成
    $json = json_encode( array( //配列をJSONに変換
        "requests" => array(
            array(
                "image" => array( //画像
                    "content" => base64_encode( file_get_contents( $image_path ) ) ,
                ) ,
                "features" => array(
                    $face ,
                    $landmark ,
                    // $logo ,
                    // $label ,
                    // $text ,
                    // $safe_search ,
                    $image_properties ,
                ) ,
            ) ,
        ) ,
    ) ) ;

    // JSONでリクエストを実行
    $curl = curl_init() ;// cURLの開始

    // オプション
    curl_setopt( $curl, CURLOPT_URL, "https://vision.googleapis.com/v1/images:annotate?key=" . API_KEY ) ;// リクエストURL (APIキーを付ける)
    curl_setopt( $curl, CURLOPT_HEADER, true ) ;// レスポンスヘッダーを取得する
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "POST" ) ;// POSTメソッドでリクエストする
    curl_setopt( $curl, CURLOPT_HTTPHEADER, array( "Content-Type: application/json" ) ) ;// ヘッダーにJSONを明示する
    curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false ) ;// 証明書の検証を行わない
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true ) ;// 取得した内容をそのまま出力せずに文字列で返す (変数に入れられる)
    if( isset($referer) && !empty($referer) ){
        curl_setopt( $curl, CURLOPT_REFERER, $referer ) ;// リファラー(許可するリファラーを設定している場合)
    }
    curl_setopt( $curl, CURLOPT_TIMEOUT, 15 ) ;// タイムアウトの秒数
    curl_setopt( $curl, CURLOPT_POSTFIELDS, $json ) ;// JSONの内容
    // データの取得
    $res1 = curl_exec( $curl ) ;// ボディの内容 (ボディとヘッダーが混ざっている)
    $res2 = curl_getinfo( $curl ) ;// ヘッダーの情報 (ヘッダーのサイズを取得して、ボディからヘッダーを引き剥がす)

    // cURLの終了
    curl_close( $curl ) ;

    // 取得したデータ
    return $json = substr( $res1, $res2["header_size"] ) ;				// 取得したJSON
    $header = substr( $res1, 0, $res2["header_size"] ) ;		// レスポンスヘッダー
}

/**
 * 引数として与えられた文字列を相当する数値に変換する。
 * @param string $likelihood
 * @return int $num
 */
function Enum2Num($likelihood){
    if($likelihood == 'VERY_UNLIKELY'){
        $num = 1;
    }elseif($likelihood == 'UNLIKELY'){
        $num = 2;
    }elseif($likelihood == 'POSSIBLE'){
        $num = 3;
    }elseif($likelihood == 'LIKELY'){
        $num = 4;
    }elseif($likelihood == 'VERY_LIKELY'){
        $num = 5;
    }else{
        $num = 0;
    }
    return $num;
}

/**
 * フォームの再入力時に、すでにセッションに対応した値があるときはその値を返却する
 * @param mixed $arg formのname属性
 * @return mixed セッションに入力されていた値
 */
function form_value($arg){
    if(isset($_POST['mode']) && $_POST['mode']=='REINPUT'){
        if(isset($_SESSION[$arg])){
            return $_SESSION[$arg];
        }
    }
    else{ //再入力時でない時、セッションにｎullを入れる。
        $_SESSION[$arg] = null;
        return $_SESSION[$arg];
    }
}

/**
 * ポストから存在チェックしてからセッションに値を渡す。
 * 二回目以降のアクセス用に、ポストから値の上書きがされない該当セッションは初期化する
 * @param mixed $arg
 * @return mixed
 */
function bind_p2s($arg){
    if(!empty($_POST[$arg])){
        $_SESSION[$arg] = $_POST[$arg];
        return $_POST[$arg];
    }else{
        $_SESSION[$arg] = null;
        return null;
    }
}




 ?>