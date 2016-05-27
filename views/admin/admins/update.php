<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = ($model->id ? 'Администратор #' . $model->id : 'Новый администратор');
$this->params['breadcrumbs'][] = ['label' => 'Администраторы', 'url' => ['/admin/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="raw">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mail:']) ?>

    <?= $form->field($model, 'password')->textInput(['placeholder' => 'Пароль:', 'value' => '']) ?>

    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
