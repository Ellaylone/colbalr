<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = $page->title;
?>
<div class="contacts">
    <div class="container contacts-info">
        <div class="secondary-menu">
            <?php
            if(sizeof($sPages) > 0){
                foreach($sPages as $sk => $spage){
                    echo Html::a($spage->title, Url::to(['site/view', 'url' => $spage->url]));
                }
            }
            ?>
        </div>
        <?php
        if(sizeof($contacts) > 0 && sizeof($contactTypes)){
            foreach ($contactTypes as $keyType => $type) {
                ?>
                <div>
                    <?php
                        foreach ($contacts as $keyContact => $contact) {
                            if($contact->type == $type->id){
                            ?>
                            <p>
                                <?php 
                                echo $type->icon . "&nbsp;";
                                echo $contact->value . "&nbsp;"; 
                                ?>
                            </p>
                             <?php
                            }
                        }
                    ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
<div class="content">
    <a name="about" class="hidden-anchor"></a>
    <div class="container">
        <?=$page->text;?>
    </div>
</div>
<div class="catalog">
    <a name="catalog" class="hidden-anchor"></a>
    <h2>наши работы</h2>
    <?php
    $catalogCarousel = [];
    foreach ($items as $key => $item) {
        array_push($catalogCarousel, "'" . Html::a(Html::tag('div') . Html::img('/uploads/items/' . $item->id . '/' . $item->thumb), Url::to(['/catalog/view', 'id' => $item->id])) . "'");
    }
    ?>
    <div id="catalogCarousel" class="slide carousel">
        <div class="carousel-inner"></div>
        <a class="left carousel-control" href="#catalogCarousel" data-slide="prev"></a>
        <a class="right carousel-control" href="#catalogCarousel" data-slide="next"></a>
    </div>
    <script>var catalogCarousel = [<?= implode(',', $catalogCarousel); ?>];</script>
    <a href="<?= Url::to(['/catalog/index']); ?>">Показать все</a>
</div>
<div class="partners hidden-xs">
    <div class="partners-inner">
        <h2>наши партнеры</h2>
        <?php
        $partnersCarousel = [];
        foreach ($partners as $key => $partner) {
            array_push($partnersCarousel, "'" . Html::img('/uploads/partners/' . $partner->id . '/' . $partner->thumb) . "'");
        }
        ?>

        <div id="partnersCarousel" class="slide carousel">
            <div class="carousel-inner"></div>
            <a class="left carousel-control" href="#partnersCarousel" data-slide="prev"></a>
            <a class="right carousel-control" href="#partnersCarousel" data-slide="next"></a>
        </div>
        <script>var partnersCarousel = [<?= implode(',', $partnersCarousel); ?>];</script>
    </div>
</div>
<div class="contactsForm">
    <div class="contactsForm-inner container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <a name="contacts" class="hidden-anchor"></a>
            <h2>Контакты</h2>
            <div class="contacts-info">
                <?php
                if(sizeof($contacts) > 0 && sizeof($contactTypesForm)){
                    foreach ($contactTypesForm as $keyType => $type) {
                        ?>
                        <div>
                            <?php
                                foreach ($contacts as $keyContact => $contact) {
                                    if($contact->type == $type->id){
                                    ?>
                                    <p>
                                        <?php 
                                        echo $type->icon . "&nbsp;";
                                        echo $contact->value . "&nbsp;"; 
                                        ?>
                                    </p>
                                     <?php
                                    }
                                }
                            ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <h2>Обратная связь</h2>
            <?php $form = ActiveForm::begin(['id' => 'contactsForm-form', 'class' => 'contactsForm-form']); ?>
                <?= $form->field($model, 'name')->textInput(['placeholder' => 'Имя:']) ?>

                <?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mail:']) ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 6, 'placeholder' => 'Текст сообщения']) ?>
                <div class="contactsForm-form__capcha hidden">
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3"></div><div class="col-lg-3">{image}</div><div class="col-lg-4" style="transform: translate(0%, 25%);">{input}</div><div class="col-lg-2"></div></div>',
                ]) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <a class="dg-widget-link" href="http://2gis.ru/kurgan/firm/1407903164707436/center/65.31811952590944,55.47548492036175/zoom/16?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=bigMap">Посмотреть на карте Кургана</a>
            <div class="dg-widget-link">
                <a href="http://2gis.ru/kurgan/center/65.317899,55.474241/zoom/16/routeTab/rsType/bus/to/65.317899,55.474241╎Лаборатория рекламы, мастерская?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=route">Найти проезд до Лаборатория рекламы, мастерская</a>
            </div>
            <script charset="utf-8" src="http://widgets.2gis.com/js/DGWidgetLoader.js"></script>
            <script charset="utf-8">new DGWidgetLoader({"width":550,"height":550,"borderColor":"#a3a3a3","pos":{"lat":55.47548492036175,"lon":65.31811952590944,"zoom":16},"opt":{"city":"kurgan"},"org":[{"id":"1407903164707436"}]});</script>
            <noscript style="color:#c00;font-size:16px;font-weight:bold;">Виджет карты использует JavaScript. Включите его в настройках вашего браузера.</noscript>
        </div>
    </div>
</div>
