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
<body>
<?php $this->beginBody() ?>

<div class="wrap row">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('images/logo.png'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            ['label' => '<span class="fa fa-home" aria-hidden="true"></span>', 'url' => ['/site/index']],
            ['label' => 'о нас', 'url' => ['/site/about']],
            ['label' => 'наши работы', 'url' => ['/site/about']],
            ['label' => 'контакты', 'url' => ['/site/about']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer row">
    <div class="container">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 footer-brand"><div class="footer-brand__logo"></div></div>
        <p class="col-xs-12 col-sm-6 col-md-6 col-lg-4 footer-copy">Лабратория рекламы 2009-<?= date('Y') ?>&copy;</p>
        <p class="col-xs-4 col-sm-2 col-md-4 col-lg-4"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
