<?php

namespace backend\controllers;

use backend\models\Message;
use backend\models\SourceMessage;
use Yii;

class TranslateController extends AppController{

    public function actionIndex()
    {
        $messages = SourceMessage::find()
            ->with('messages')
            ->all();

        return $this->render('index',[
            'messages' => $messages,
            'langs' => $this->getLangs(),
        ]);
    }

    public function actionSave(){
        $message = Message::find()
            ->where([
                'id' => Yii::$app->request->post('id'),
                'language' => Yii::$app->request->post('lang'),
            ])
            ->limit(1)
            ->one();
        if($message != null){
            $message->translation = Yii::$app->request->post('string');
            if($message->save()){
                Yii::$app->session->setFlash('success', Yii::t('app','Сохранено'));
            }

        }
        return $this->renderAjax('save',[
            'id' => Yii::$app->request->post('id'),
            'lang' => Yii::$app->request->post('lang'),
            'string' => Yii::$app->request->post('string'),
        ]);

    }

}
