<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body id="login">
<?php $this->beginBody() ?>
<main>
    <div class="container" id="login-box">
        <div class="row">
            <div class="col-md-1"> </div>
            <div class="col-md-4" id="logo">
                <div class="row">
                    <div class="col-md-6" id="logo-img">
                        <?=Html::img('@web/images/imdj.png',['alt'=>'IMDJ Logo Imagem']) ?>
                    </div>
                    <div class="col-md-6 hidden-xs hidden-sm">
                        <div class="lines">
                            <span id="black" class="line"></span>
                            <span id="green" class="line"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 transition">
                <?=$content?>
            </div>
            <div class="col-md-1"> </div>
        </div>
    </div>
</main>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
