<?php 

require_once 'defineUtil.php';
require_once 'scriptUtil.php';
require_once 'dbaccessUtil.php';

class MUCHA_BURI{
    //クラス内変数の定義
    private $_image_file = [];

    //ネタ画像をカプセル化するメソッド
    public function setIMAGE($image_file) {
        $this->_image_file = $image_file;
    }
    
    //ネタ画像を画像認識APIにて認識し、特徴を取得するメソッド
    private function recognizeIMAGE(){
        //APIで取得したJSONを返却
        $imgFeature = CLOUD_VISON_API($this->_image_file);
        //JSONをPHPオブジェクトに変換
        $imgFeature_obj = json_decode($imgFeature);
        //認識した画像に人が含まれているか判別する。
        if( empty($imgFeature_obj->responses[0]->faceAnnotations[0]) ){
            $typeID = 2; //non-human
            $expression = null;
        }
        else{
            $typeID = 1; //human
            $faceFeature = $imgFeature_obj->responses[0]->faceAnnotations[0];
            $expression_list = array(
                                'joyLikelihood' => Enum2Num($faceFeature->joyLikelihood),
                                'sorrowLikelihood' => Enum2Num($faceFeature->sorrowLikelihood),
                                'angerLikelihood' => Enum2Num($faceFeature->angerLikelihood),
                                'surpriseLikelihood' => Enum2Num($faceFeature->surpriseLikelihood) );
            $max_expression_list = max($expression_list);
            $expression_array = array_keys($expression_list, $max_expression_list);
            $expression = implode(',', $expression_array);
        }
        return array('imgFeature' => $imgFeature, 'typeID' => $typeID, 'expression' => $expression );
    }
    
    //サンプルデータからネタ画像とマッチングする画像を検索するメソッド
    public function searchIMAGE(){
        $imgFeature_array = $this->recognizeIMAGE();
        // var_dump($imgFeature_array);
        //recognizeIMAGEで取得した画像の特徴(配列)を変数に格納
        $imgFeature = $imgFeature_array['imgFeature'];
        $typeID = $imgFeature_array['typeID'];
        $expression = $imgFeature_array['expression'];
        //DBのsourceテーブルからレコードを取得
        $selectSOURCE_result = selectSOURCE($typeID, $expression);
        //検索の成功判別する。
        if( is_array($selectSOURCE_result) ){
            $selectSOURCE_num = count($selectSOURCE_result); //検索された結果の数を格納する変数
            
            // echo 'マッチしたレコードの数は'.$selectSOURCE_num.'件です。';
            $Degree_of_similarity = 0; //文字列の類似度を格納する変数
            for($i = 0; $i < $selectSOURCE_num; $i++){
                similar_text($imgFeature, $selectSOURCE_result[$i], $percent);
                if($Degree_of_similarity < $percent){
                    $Degree_of_similarity = $percent;
                    $neta = $i;
                }
            }
            echo $Degree_of_similarity.'%<br>';
            echo $neta.'<br>';
        }
        else{
            echo '素材データの検索に失敗しました。以下の理由により処理を中断します'.$selectSOURCE_result;
        }
    }
    
}


class SOURCE{
    //クラス内変数の定義
    private $_source_file = [];
    private $_url = [];
    
    //素材をカプセル化するメソッド
    public function setSOURCE($source_file) {
    $this->_source_file = $source_file;
    }
    
    //素材を読み込むメソッド
    private function getSOURCE(){
        //JSON形式の素材データの中身を取得
        $source_json = file_get_contents($this->_source_file);
        //JSON形式からPHPオブジェクト形式へ変換
        $source_obj = json_decode($source_json);
        return $source = $source_obj->results->collection1;
    }
    
    //素材の画像を画像認識APIにて認識し、特徴を取得するメソッド
    private function recognizeSOURCE(){
        //APIで取得したJSONを返却
        $imgFeature = CLOUD_VISON_API($this->_url);
        //JSONをPHPオブジェクトに変換
        $imgFeature_obj = json_decode($imgFeature);
        //認識した画像に人が含まれているか判別する。
        if( empty($imgFeature_obj->responses[0]->faceAnnotations[0]) ){
            $typeID = 2; //non-human
            $expression = null;
        }
        else{
            $typeID = 1; //human
            $faceFeature = $imgFeature_obj->responses[0]->faceAnnotations[0];
            $expression_list = array(
                                'joyLikelihood' => Enum2Num($faceFeature->joyLikelihood),
                                'sorrowLikelihood' => Enum2Num($faceFeature->sorrowLikelihood),
                                'angerLikelihood' => Enum2Num($faceFeature->angerLikelihood),
                                'surpriseLikelihood' => Enum2Num($faceFeature->surpriseLikelihood) );
            $max_expression_list = max($expression_list);
            $expression_array = array_keys($expression_list, $max_expression_list);
            $expression = implode(',', $expression_array);
        }
        return array('imgFeature' => $imgFeature, 'typeID' => $typeID, 'expression' => $expression );
    }
    
    //素材をデータベースのsourceテーブルに格納するメッソド
    public function saveSOURCE(){
        $count = 0; //格納に成功したレコードの数
        foreach ($this->getSOURCE() as $source) {
            foreach ($source as $property => $content) {
                switch ($property) {
                    case 'property1':
                        //画像のURLを取得
                        $this->_url = $content->src;
                        //取得したURLの画像の特徴をAPIで取得
                        $imgFeature_array = $this->recognizeSOURCE();
                        $typeID = $imgFeature_array['typeID'];
                        $expression = $imgFeature_array['expression'];
                        $imgFeature = $imgFeature_array['imgFeature'];
                        break;
                    case 'property2':
                        //コメントを取得
                        $comment = $content;
                        break;
                }
            }
            //データベースへの挿入を実行
            $insertSOURCE_result = insertSOURCE($this->_url, $comment, $typeID, $expression, $imgFeature);
            if( empty($insertSOURCE_result) ){
                $count++;
            }
            else{
                echo '素材データの挿入に失敗しました。以下の理由により処理を中断します'.$insertSOURCE_result;
            }
        }
        return $count.'件のデータの登録に成功しました。';
    }

}





?>