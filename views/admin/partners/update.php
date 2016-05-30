<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = ($model->id ? $model->title : 'Новый партнер');
$this->params['breadcrumbs'][] = ['label' => 'Партнеры', 'url' => ['/admin/partners']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="raw">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'title') ?>

    <?php
        if($model->thumb != null){
            echo Html::img('/uploads/partners/' . $model->id . '/' . $model->thumb);
        }
    ?>
    <?= $form->field($model, 'thumb')->fileInput() ?>

    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
