<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Страницы';
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
            'title:text:Заголовок',
            'url:text:Ссылка',
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
                'template' => '{parent}',
                'buttons' => [
                    'parent' => function($url, $model){
                        return Html::beginForm([$url]) . Html::input(
                            'text',
                            'parent',
                            $model->parent,
                            ['class' => 'col-lg-9 col-md-9 col-sm-9 col-xs-8']
                        ) . Html::submitButton(
                            '<i class="fa fa-check" aria-hidden="true"></i>',
                            ['class' => 'submitParent col-lg-3 col-md-3 col-sm-3 col-xs-4']
                        ) . Html::endForm();
                    },
                ],
                'header' => 'Родитель',
                'contentOptions' => [
                    'class' => 'raw col-lg-2 col-md-2 col-sm-3 col-xs-3'
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{status}{type}{update}{delete}',
                'buttons' => [
                    'status' => function($url, $model){
                        return Html::a(
                            '<i style="color: ' . ($model->status ? 'green' : 'red') . '" class="fa fa-eye" aria-hidden="true"></i>',
                            $url,
                            ['class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3',
                             'title' => ($model->status ? 'Видима: Показывается в меню и доступна для просмотра' : 'Скрыта: Не показывается в меню, не доступна для просмотра'),
                             'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                    'type' => function($url, $model){
                        return Html::a(
                            '<i style="color: ' . (!$model->type ? 'green' : 'red') . '" class="fa fa-anchor" aria-hidden="true"></i>',
                            $url,
                            ['class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3',
                             'title' => (!$model->type ? 'Якорь: Указывает на метку на странице' : 'Ссылка: Генерирует простую страницу'),
                             'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                    'update' => function($url, $model){
                        return Html::a(
                            '<i class="fa fa-pencil" aria-hidden="true"></i>',
                            $url,
                            ['class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3',
                             'title' => 'Редактировать',
                             'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                    'delete' => function($url, $model){
                        return Html::a(
                            '<i class="fa fa-trash" aria-hidden="true"></i>',
                            $url,
                            ['class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3',
                             'title' => 'Удалить',
                             'data-toggle' => 'tooltip',
                            ]
                        );
                    },
                ],
                'contentOptions' => [
                    'class' => 'raw col-lg-2 col-md-2 col-sm-3 col-xs-3'
                ],
            ],
        ],
    ]);
    ?>
    <?=Html::a(
        '<i class="fa fa-plus" aria-hidden="true"></i> Добавить',
        ['/admin/pages/update/0'],
        ['class' => 'btn btn-primary pull-right']
    );
    ?>
</div>
