<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\models\Pages;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
    <link rel="icon" href="/favicon.png" type="image/x-icon">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    asdasdasdasdasdl;askjda;lksjd
<div class="wrap row">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('/images/logo.png'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $pages = Pages::find()
           ->where(['status' => '1'])
           ->andWhere(['<>', 'url', 'homepage'])
           ->all();

    $items = [
        ['label' => '<span class="hidden catalog-back">назад</span>', 'url' => '#'],
        ['label' => '<span class="fa fa-home" aria-hidden="true"></span>', 'url' => ['/site/index']],
        ['label' => 'о нас', 'url' => '#about'],
        ['label' => 'наши работы', 'url' => '#catalog'],
        ['label' => 'контакты', 'url' => '#contacts'],
    ];

    foreach($pages as $k => $page){
        array_push($items, [
            'label' => $page->title,
            'url' => Url::to(['site/view', 'url' => $page->url]),
        ]);
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer row">
    <div class="container">
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 footer-brand"><div class="footer-brand__logo"></div></div>
        <p class="col-xs-12 col-sm-6 col-md-6 col-lg-4 footer-copy">Лабратория рекламы 2009-<?= date('Y') ?>&copy;</p>
        <p class="hidden-xs hidden-sm col-xs-4 col-sm-2 col-md-3 col-lg-4"></p>
    </div>
</footer>

<a class="anchor-top" href="#top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
<?php
if($this->context->id == 'catalog'){
?>
    <script>var showBack = true;</script>
<?php
}
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
