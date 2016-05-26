<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Каталог';
?>
<div class="site-about container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="catalog-all">
        <?php
        foreach ($items as $key => $item) {
            echo Html::a(
                Html::tag('div') . Html::img('/uploads/' . $item->thumb),
                Url::to(['/catalog/view', 'id' => $item->id]),
                ['class' => 'catalog-all__one col-xs-6 col-sm-6 col-md-4 col-lg-3']
            );
        }
        ?>
    </div>
</div>
