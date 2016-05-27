<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $page->title;
?>
<div class="site-about container">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $page->text; ?>
</div>
