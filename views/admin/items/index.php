<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Каталог';
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
            'name:text:Заголовок',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{sort}',
                'buttons' => [
                    'sort' => function($url, $model){
                        return Html::beginForm([$url]) . Html::input(
                            'text',
                            'sort',
                            $model->sort,
                            ['class' => 'col-lg-9 col-md-9 col-sm-9 col-xs-8']
                        ) . Html::submitButton(
                            '<i class="fa fa-check" aria-hidden="true"></i>',
                            ['class' => 'submitSort col-lg-3 col-md-3 col-sm-3 col-xs-4']
                        ) . Html::endForm();
                    },
                ],
                'header' => 'Сортировка',
                'contentOptions' => [
                    'class' => 'raw col-lg-2 col-md-2 col-sm-3 col-xs-3'
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{status}{carousel}{update}{delete}',
                'buttons' => [
                    'status' => function($url, $model){
                        return Html::a(
                            '<i style="color: ' . ($model->status ? 'green' : 'red') . '" class="fa fa-eye" aria-hidden="true"></i>',
                            $url,
                            [
                                'class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3',
                                'title' => ($model->status ? 'Активен: Показывается в каталоге, доступен для просмотра' : 'Неактивен: Не показывается в каталоге, не доступен для просмотра'),
                                'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                    'carousel' => function($url, $model){
                        return Html::a(
                            '<i style="color: ' . ($model->carousel ? 'green' : 'red') . '" class="fa fa-picture-o" aria-hidden="true"></i>',
                            $url,
                            [
                                'class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3',
                                'title' => ($model->carousel ? 'Активен: Выводится в слайдере каталога' : 'Неактивен: Не выводится в слайдере каталога'),
                                'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                    'update' => function($url, $model){
                        return Html::a(
                            '<i class="fa fa-pencil" aria-hidden="true"></i>',
                            $url,
                            [
                                'class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3',
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
                                'class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3',
                                'title' => 'Удалить',
                                'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                ],
                'contentOptions' => [
                    'class' => 'raw col-lg-2 col-md-2 col-sm-3 col-xs-4'
                ],
            ],
        ],
    ]);
    ?>
    <?=Html::a(
        '<i class="fa fa-plus" aria-hidden="true"></i> Добавить',
        ['/admin/items/update/0'],
        ['class' => 'btn btn-primary pull-right']
    );
    ?>
</div>
