<?php


namespace backend\controllers;

use backend\models\Lang;
use backend\models\Option;
use backend\models\OptionLang;
use yii\web\Controller;

class AppController extends Controller
{
    /**
     * Отримуємо активні мови
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getLangs(){
        return Lang::find()->where(['status'=>1])->all();
    }

    /**
     * отримуємо значення опції за її ім'ям
     * @param $name
     * @param bool $serialize
     * @return bool|mixed|null
     */
    protected function getOption($name, $serialize = false, $model = false, $img = false, $attr=[]){
        $option = Option::find()->where(['name'=>$name])->limit(1)->one();
        if($model) return $option;
        if($option==null) return false;

        if($serialize){
            return unserialize($option->value);
        }elseif($img){
            $image = $option->getImageByName($name);
            if($image != null){
                if(isset($attr['img_size'])){
                    return $image->getPathSVG($attr['img_size']);
                }else{
                    return $image->getUrlToOrigin();
                }
            }else{
                return null;
            }
        }else{
            return $option->value;
        }
    }

    /**
     * Оновлюємо опцію
     * якщо опції з заданим ім'ям нема то створе нову інакше оновить
     * @param $name
     * @param $value
     * @param bool $serialize
     * @param bool $img
     * @return int
     */
    protected function updOption($name, $value, $serialize = false, $img = false){
        $option = $this->getOption($name,$serialize,true);
        if($option==null){
            $option = new Option();
        }
        $option->value = $serialize?serialize($value):$value;
        $option->name = $name;
//        debug($option);die();
        $result = false;
        if($option->save()){
            $result = true;
            if($img != false && $value != ''){
                $savedImg = $option->getImageByName($name);
                if($savedImg){
                    $option->removeImageNoDel($savedImg);
                }
                $option->attachImageNotUpload($value, $isMain = false, $name);
            }
        }

        return $result;
//        return Option::updateAll(['value'=>($serialize?serialize($value):$value)],['name'=>$name]);
    }

    public function updPageOption($name, $model){
        $pageOption = $this->getOption($name,true,true);
        if($pageOption == null){
            $pageOption = new Option();
            $pageOption->name = $name;
        }
        $pageOption->value = serialize($model->data);
        if($pageOption->save()){
            if($model->langs != null){
                foreach ($model->langs as $lang_id => $lang){
                    $optionLang = OptionLang::find()
                        ->where([
                            'option_id' => $pageOption->id,
                            'lang_id' => $lang_id,
                        ])
                        ->limit(1)
                        ->one();
                    if($optionLang == null){
                        $optionLang = new OptionLang();
                        $optionLang->option_id = $pageOption->id;
                        $optionLang->lang_id = $lang_id;
                    }
                    $optionLang->data = serialize($lang);
                    $optionLang->save();
                }
            }
        }
    }
    public function getPageOption($name, $attr=[]){
        $option = Option::find()->where(['name'=>$name])->with('texts')->limit(1)->one();
        return $option;
    }
}