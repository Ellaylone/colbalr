<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Изображения';
$this->params['breadcrumbs'][] = $this->title;
echo newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 3000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '80%',
        'height' => '80%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'locked' => false,
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);
?>
<div class="raw">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'image[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="form-group">
    <?= Html::submitButton('<i class="fa fa-plus" aria-hidden="true"></i> Добавить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<div class="raw">
    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'columns' => [
            'id:text:Ид',
            [
                'attribute'=>'image',
                'label'=>'Изображение',
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'name'];
                },
                'content'=>function($data){
                    if($data->image != null){
                        return Html::a(Html::img('/uploads/images/thumb_' . $data->image), '/uploads/images/' . $data->image, ['rel' => 'fancybox']);
                    } else {
                        return '';
                    }
                }
            ],
            [
                'attribute'=>'image',
                'label'=>'Код',
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'name'];
                },
                'format' => 'raw',
                'content'=>function($data){
                    if($data->image != null){
                        return Html::tag('pre', Html::tag('code', htmlspecialchars(Html::a(Html::img('/uploads/images/' . $data->image), '/uploads/images/' . $data->image, ['rel' => 'fancybox']))));
                    } else {
                        return '';
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a(
                            '<i class="fa fa-trash" aria-hidden="true"></i>',
                            $url,
                            [
                                'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12',
                                'title' => 'Удалить',
                                'data-toggle' => 'tooltip',
                                'style' => 'text-align: center',
                            ]
                        );
                    },
                ],
                'contentOptions' => [
                    'class' => 'raw col-lg-1 col-md-1 col-sm-1 col-xs-1'
                ],
            ],
        ],
    ]);
    ?>
</div>
