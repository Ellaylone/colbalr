<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use app\assets\AdminAsset;

AdminAsset::register($this);
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
<div class="wrap row">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $items = [
        ['label' => 'Страницы', 'url' => ['/pages/index']],
        ['label' => 'Изображения ', 'url' => ['/images/index']],
        ['label' => 'Каталог', 'url' => ['/items/index']],
        ['label' => 'Партнеры', 'url' => ['/partners/index']],
        ['label' => 'Контакты', 'url' => ['/contacts/index']],
        ['label' => 'Администраторы', 'url' => ['/admin/index']],
        ['label' => '<span class="fa fa-home" aria-hidden="true"></span> перейти на сайт', 'url' => ['/site/index']],
        ['label' => 'выйти (' . (Yii::$app->user->identity?Yii::$app->user->identity->email:'администратор') . ')', 'url' => ['/admin/logout']],
    ];
    if(Yii::$app->user->identity){
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,
            'items' => $items,
        ]);
    }
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => Yii::t('yii', 'Админка'),
                'url' => Url::to(['admin/index']),
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p>Лабратория рекламы 2009-<?= date('Y') ?>&copy;</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
