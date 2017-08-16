<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="login-form" class="form active">
    <?php $form = ActiveForm::begin(['validateOnBlur' => false]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe', ['inputTemplate' => '{input}<span class="ckbox"></span>'])->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('ENTRAR', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <button class="btn btn-default" id="cadastrar">CADASTRAR-SE</button>

</div>

<div id="cadastro-form" class="form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($usuario, 'email') ?>
    <?= $form->field($usuario, 'nome') ?>
    <?= $form->field($usuario, 'senha')->passwordInput() ?>
    <?= $form->field($usuario, 'senhaRepeat')->passwordInput() ?>
    <?= $form->field($usuario, 'imagem')->fileInput(['style'=>'display: none;'])->label('<div id="imgSelect" class="row">
        <div class="col-xs-4">
            '.Html::img('@web/images/fileImgPic.png').'
        </div>
        <div class="col-xs-8">
            <p>Clique aqui e selecione sua imagem de perfil.</p>
        </div>
    </div>') ?>
    <div class="form-group">
        <?= Html::submitButton('CADASTRAR', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <button class="btn btn-default" id="logar">VOLTAR</button>
</div>
