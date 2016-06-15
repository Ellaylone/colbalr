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
echo newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 3000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '80%',
        'height' => '80%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'locked' => false,
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);
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
    <meta name="description" content="<?= Html::encode($this->params['description']) ?>">
    <meta name="keywords" content="<?= Html::encode($this->params['keywords']) ?>">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap row">
    <?php
    if(strpos(Url::current(['lg'=>NULL], FALSE), 'catalog') > 0){
        $backClass = '';
        $navbarClass = 'hidden';
    } else {
        $backClass = 'hidden';
        $navbarClass = '';
    }
    echo Html::tag('div', Html::a('назад', '#', ['class' => 'catalog-back ' . $backClass]), ['class' => 'back-wrap']);
    NavBar::begin([
        'brandLabel' => ($navbarClass == 'hidden' ? '' : Html::img('/images/logo.png')),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $homepage = Pages::find()
          ->where(['status' => '1'])
          ->andWhere(['url' => 'homepage'])
          ->one();
    $pages = Pages::find()
          ->where(['type' => '1'])
          ->andWhere(['parent' => 0])
          ->orWhere(['parent' => $homepage->id])
          ->andWhere(['status' => '1'])
          ->orderBy('sort')
          ->all();
    $items = [];
    $customtype = [
        'class' => 'customtype'
    ];
    foreach($pages as $k => $page){
        $url = '';
        if($page->type){
            $url = Url::to(['site/view', 'url' => $page->url]);
        } else {
            $url = '/' . $page->url;
        }
        if($page->url == 'homepage'){
            $item = [
                'label' => '<span class="fa fa-home" aria-hidden="true"></span>',
                'url' => ['/site/index']
            ];
            array_push($items, $item);

        } else {
            if($page->type){
                $innerPages = Pages::find()
                    ->where(['parent' => $page->id])
                    ->andWhere(['status' => '1'])
                    ->orderBy('sort')
                    ->all();
                if(sizeof($innerPages) > 0){
                    $iItems = [];
                    foreach($innerPages as $ik => $ipage){
                        if(!$ipage->type){
                            $iurl = Url::to(['site/view', 'url' => $page->url]) . (substr($ipage->url, 0, 1) === '#' ? '' : '#') . $ipage->url;
                        } else {
                            $iurl = Url::to(['site/view', 'url' => $ipage->url]);
                        }
                        $iItem = [
                            'label' => $ipage->title,
                            'url' => $iurl,
                        ];
                        array_push($iItems, $iItem);
                        /* if($ik != sizeof($innerPages) - 1){
                           array_push($iItems, '<li class="divider"></li>');
                           } */
                    }
                    $item = [
                        'label' => $page->title,
                        'items' => $iItems,
                        'options' => ($page->customtype ? $customtype : []),
                    ];
                } else {
                    $item = [
                        'label' => $page->title,
                        'url' => $url,
                        'options' => ($page->customtype ? $customtype : []),
                    ];
                }
            } else {
                $item = [
                    'label' => $page->title,
                    'url' => $url,
                    'options' => ($page->customtype ? $customtype : []),
                ];
            }
            array_push($items, $item);
        }
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right ' . $navbarClass],
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
