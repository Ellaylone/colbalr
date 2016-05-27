<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = ($model->id ? 'Контакт #' . $model->id : 'Новый контакт');
$this->params['breadcrumbs'][] = ['label' => 'Контакты', 'url' => ['/admin/contacts']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="raw">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'value')->textInput(['placeholder' => 'Значение:']) ?>

    <?= $form->field($model, 'type')->dropDownList(
        $contactTypes,
        ['prompt' => '']
    ) ?>

    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
