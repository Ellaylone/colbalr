<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Items;

class CatalogController extends Controller
{
	public function actionIndex()
    {
    	$items = Items::find()
            ->where(['status' => 1, 'carousel' => 1])
            ->orderBy('sort')
            ->all();
    	return $this->render('index', [
    		'items' => $items,
    	]);
    }
}
