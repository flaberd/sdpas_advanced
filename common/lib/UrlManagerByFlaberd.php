<?php


namespace common\lib;


use codemix\localeurls\UrlManager;
use frontend\models\Lang;

class UrlManagerByFlaberd extends UrlManager
{
    public function __construct($config = [])
    {
        $langs = Lang::find()->where(['status'=>1])->all();
        $langsPrefix = [];
        foreach ($langs as $lang){
            $langsPrefix[] = $lang->prefix;
        }
        $this->languages = $langsPrefix;
        parent::__construct($config);
    }
}