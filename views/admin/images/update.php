<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = ($model->id ? $model->name : 'Новый товар');
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['/admin/images']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="raw">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'name') ?>

    <?php
        if($model->thumb != null){
            echo Html::img('/uploads/images/' . $model->id . '/' . $model->thumb);
        }
    ?>
    <?= $form->field($model, 'thumb')->fileInput() ?>

    <?= $form->field($model, 'text')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
