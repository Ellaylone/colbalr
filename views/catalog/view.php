<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $item->name;
?>
<div class="site-about container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="catalog-one">
        <?php
            echo $item->text;
        ?>
    </div>
</div>
