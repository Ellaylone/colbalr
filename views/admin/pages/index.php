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
                'template' => '{sort}{toggle}{anchor}{update}{delete}',
                'buttons' => [
                    'sort' => function($url, $model){
                        return Html::a(
                            '',
                            // '<i class="fa fa-pencil" aria-hidden="true"></i>',
                            $url,
                            ['class' => 'col-lg-4 col-md-4 col-sm-4 col-xs-4']
                        );
                    },
                    'toggle' => function($url, $model){
                        return Html::a(
                            '<i style="color: ' . ($model->status ? 'green' : 'red') . '" class="fa fa-eye" aria-hidden="true"></i>',
                            $url,
                            ['class' => 'col-lg-2 col-md-2 col-sm-2 col-xs-2']
                        );
                    },
                    'anchor' => function($url, $model){
                        return Html::a(
                            '<i style="color: ' . (!$model->type ? 'green' : 'red') . '" class="fa fa-anchor" aria-hidden="true"></i>',
                            $url,
                            ['class' => 'col-lg-2 col-md-2 col-sm-2 col-xs-2']
                        );
                    },
                    'update' => function($url, $model){
                        return Html::a(
                            '<i class="fa fa-pencil" aria-hidden="true"></i>',
                            $url,
                            ['class' => 'col-lg-2 col-md-2 col-sm-2 col-xs-2']
                        );
                    },
                    'delete' => function($url, $model){
                        return Html::a(
                            '<i class="fa fa-trash" aria-hidden="true"></i>',
                            $url,
                            ['class' => 'col-lg-2 col-md-2 col-sm-2 col-xs-2']
                        );
                    },
                ],
                'contentOptions' => [
                    'class' => 'raw col-lg-3 col-md-3 col-sm-4 col-xs-4'
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
