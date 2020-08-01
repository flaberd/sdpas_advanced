<?php


namespace backend\models;


use yii\base\Model;

class FormOptions extends Model{

    public $adminEmail;
    public $binotel;
    public $gtm_head;
    public $gtm_end;
    public $assetCompres;
    public $favIcon;

    public $wayfopay_merchant;
    public $wayfopay_secret;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
//            [[
//            ], 'string'],
            [[
                'adminEmail',
                'binotel',
                'gtm_head',
                'gtm_end',
                'assetCompres',
                'favIcon',
            ],'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'adminEmail'=>\Yii::t('app','Emal администратора (если несколько то церез зяпятую)'),
            'binotel'=>\Yii::t('app','Код бинотел'),
            'gtm_head'=>\Yii::t('app','Код ГТМ шапка'),
            'gtm_end'=>\Yii::t('app','Код ГТМ верх боди'),
            'assetCompres'=>\Yii::t('app','Сжатие CSS и js'),
            'favIcon'=>\Yii::t('app','Фавикон'),
        ];
    }

}