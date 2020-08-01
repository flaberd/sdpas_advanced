<?php

namespace backend\controllers;

use backend\models\FormOptions;
use backend\models\Option;
use Yii;
use yii\helpers\ArrayHelper;

class OptionController extends AppController{
    public function actionIndex()
    {
        $model = new FormOptions();

        if($model->load(\Yii::$app->request->post())){
            $this->updOption('adminEmail',$model->adminEmail);
            $this->updOption('binotel',$model->binotel);
            $this->updOption('gtm_head',$model->gtm_head);
            $this->updOption('gtm_end',$model->gtm_end);
            $this->updOption('assetCompres',$model->assetCompres);
            $this->updOption('favIcon',$model->favIcon,false,true);
            Yii::$app->session->setFlash('success', Yii::t('app','Сохранено'));
            return $this->refresh();
        }

        $model->adminEmail = $this->getOption('adminEmail');
        $model->binotel = $this->getOption('binotel');
        $model->gtm_head = $this->getOption('gtm_head');
        $model->gtm_end = $this->getOption('gtm_end');
        $model->assetCompres = $this->getOption('assetCompres');
        $model->favIcon = $this->getOption('favIcon', false, false, true);


        return $this->render('index',[
            'model' =>  $model,

        ]);
    }
}
