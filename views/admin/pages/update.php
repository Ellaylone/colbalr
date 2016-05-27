<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = ($model->id ? $model->title : 'Новая страница');
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['/admin/pages']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="raw">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'text')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'url') ?>

    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
