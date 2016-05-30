<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Администраторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="raw">
    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered'
        ],
        'columns' => [
            'id:text:Ид',
            'email:text:Email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model){
                        return Html::a(
                            '<i class="fa fa-pencil" aria-hidden="true"></i>',
                            $url,
                            [
                                'class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6',
                                'title' => 'Редактировать',
                                'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                    'delete' => function($url, $model){
                        return Html::a(
                            '<i class="fa fa-trash" aria-hidden="true"></i>',
                            $url,
                            [
                                'class' => 'col-lg-6 col-md-6 col-sm-6 col-xs-6',
                                'title' => 'Удалить',
                                'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                ],
                'contentOptions' => [
                    'class' => 'raw col-lg-1 col-md-1 col-sm-2 col-xs-3'
                ],
            ],
        ],
    ]);
    ?>
    <?=Html::a(
        '<i class="fa fa-plus" aria-hidden="true"></i> Добавить',
        ['admin/update/', 'id' => 0],
        ['class' => 'btn btn-primary pull-right']
    );
    ?>
</div>
