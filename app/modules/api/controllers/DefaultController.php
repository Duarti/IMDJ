<?php

namespace app\modules\api\controllers;

use app\models\Musica;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;


/**
 * Default controller for the `api` module
 */
class DefaultController extends ActiveController
{

    public $modelClass = "app\models\Musica";

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        return $actions;
    }

    public function actionIndex(){
        echo Json::encode(Musica::findAll(['usuario_id'=>\Yii::$app->user->identity->id]));
    }

    public function actionView($id){
        echo Json::encode(Musica::findOne(['usuario_id'=>\Yii::$app->user->identity,'id'=>$id]));
    }

}
