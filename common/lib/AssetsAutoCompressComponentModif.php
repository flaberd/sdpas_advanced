<?php


namespace common\lib;


use app\models\Option;
use backend\controllers\AppController;
use skeeks\yii2\assetsAuto\AssetsAutoCompressComponent;

class AssetsAutoCompressComponentModif extends AssetsAutoCompressComponent{

    public function __construct($config = [])
    {
        $option = Option::find()->where(['name'=>'assetCompres'])->limit(1)->one();
        $this->enabled = false;
        if($option != null){
            if((int)$option->value == 1){
                $this->enabled = true;
            }
        }
        parent::__construct($config);
    }

//    public function __construct($config = [])
//    {
////        $langs = Lang::find()->where(['status'=>1])->all();
////        $langsPrefix = [];
////        foreach ($langs as $lang){
////            $langsPrefix[] = $lang->prefix;
////        }
////        $this->languages = $langsPrefix;
//        parent::__construct($config);
//    }

}