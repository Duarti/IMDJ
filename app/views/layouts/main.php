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
<body id="home" class="transition">
<?php $this->beginBody() ?>
<header>
    <div class="container" id="top">
        <div class="row">
            <div class="col-xs-4 center cold-md-4" id="logo">
                <?= Html::img('@web/images/imdj.png', ['alt' => 'IMDJ Logo Imagem']) ?>
                <div class="lines">
                    <span id="black" class="line"></span>
                    <span id="green" class="line"></span>
                </div>
            </div>
            <div class="col-md-4 hidden-xs hidden-sm"> </div>
            <div class="col-xs-8 col-md-4">
                <?php if (!Yii::$app->user->isGuest) { ?>
                    <ul id="user-menu">
                        <li id="user-dropdown">
                            Olá, <b><?= Yii::$app->user->identity->nome ?></b> <span class="triangle"></span>
                            <ul>
                                <li>
                                    <?= Html::beginForm(['/site/logout'], 'post')
                                    . Html::submitButton(
                                        'Logout',
                                        ['class' => 'btn btn-primary logout']
                                    )
                                    . Html::endForm() ?>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php if (Yii::$app->user->identity->imagem != null) { ?>
                                <?= Html::img('@web/usuarios/' . Yii::$app->user->identity->id . '/' . Yii::$app->user->identity->imagem, ['id' => 'user-image']) ?>
                            <?php } else { ?>
                                <?= Html::img('@web/images/unknown.png', ['id' => 'user-image']) ?>
                            <?php } ?>
                        </li>
                    </ul>
                <?php } else { ?>
                    <ul id="user-menu">
                        <li id="user-dropdown">
                            <?=Html::a('Login','site/login',['class'=>'btn btn-primary'])?>
                        </li>
                        <li>
                            <?= Html::img('@web/images/unknown.png', ['id' => 'user-image']) ?>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</header>
<main>
    <div class="container blur ">
        <?= $content ?>
    </div>
</main>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
