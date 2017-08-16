<?php

namespace app\controllers;

use app\models\Usuario;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\BaseFileHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index','load'],
                'rules' => [
                    [
                        'actions' => ['logout','index','load'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        $this->layout = "login";

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $usuario = new Usuario();

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $usuario = Yii::$app->user->identity;
            $usuario->senhaRepeat = $usuario->senha;
            $usuario->token = md5(Yii::$app->request->userIP.'HeIsaDJ'.$usuario->email);
            if($usuario->save()){
                $this->redirect(['site/load'],301);
            } else {
                Yii::$app->user->identity->errors;
                die();
            }
        } else if($usuario->load(Yii::$app->request->post())){
            if($usuario->senha != "" && $usuario->senhaRepeat != ""){
                $usuario->senha = md5($usuario->senha);
                $usuario->senhaRepeat = md5($usuario->senhaRepeat);
            }
            $usuario->token = md5(Yii::$app->request->userIP.'HeIsaDJ'.$usuario->email);
            $file = UploadedFile::getInstance($usuario, 'imagem');
            $name = md5($file->name);
            $usuario->imagem = $name;
            if($usuario->save()){
                $helper = new BaseFileHelper();
                $helper->createDirectory('usuarios/'.$usuario->id);
                $file->saveAs('usuarios/'.$usuario->id.'/'.$name);
                Yii::$app->user->login($usuario);
                $this->redirect(['site/load'],301);
            }
        }
        return $this->render('login', [
            'model' => $model,
            'usuario' => $usuario
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionLoad(){

        $this->layout = 'load';

        return $this->render('load', [
            'usuario' => Yii::$app->user->identity
        ]);
    }

}
