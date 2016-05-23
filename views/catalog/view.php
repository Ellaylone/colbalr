<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $item->name;
?>
<div class="site-about container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="catalog-one">
        <?php
            echo Html::img('uploads/' . $item->thumb, ['class' => 'col-xs-6 col-sm-6 col-md-4 col-lg-3']);
            echo $item->text;
        ?>
    </div>
</div>
