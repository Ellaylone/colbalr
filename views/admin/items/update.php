<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = ($model->id ? $model->name : 'Новый товар');
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/admin/items']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="raw">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'text')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
