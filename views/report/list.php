<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;


/* @var $this yii\web\View */
$this->title = 'ข้อมูล: ' . $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1 style="margin-top: -14px;margin-bottom: 16px"><?= Html::encode($this->title) ?></h1>

    <div class="row">

        <div class="col-md-9">


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-th-list"></i> ข้อมูล</h4>
                </div>

                <div class="panel-body">
                    <div class="">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'striped' => false,

                            'bordered' => true,
                            'hover' => true,
                            'responsive' => false,
                            'containerOptions' => ['style' => 'overflow: auto', 'class' => 'panel-inverse'],
                            'condensed' => true,
                            'responsiveWrap' => false,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [

                                    'label' => 'ชื่อรายงาน', 'attribute' => 'title',
                                    'format' => 'raw', 'value' => function ($d) {

//                                    $param_array = str_replace('repid-link', 'ref', urldecode(Yii::$app->request->queryString));
//                                    $param_array = str_replace('cat-link', 'ref', $param_array);
//                                    $param_array = empty($param_array) ? '' : '&' . $param_array;

                                    $param_array= '';

                                    return Html::a($d['title'], Url::to(['/report/view', 'repid-link' => $d['id'], 'cat-link'=>Yii::$app->getRequest()->getQueryParam('id')]) . $param_array);

                                }

                                ],

                                //['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-3">

            <?php $form = ActiveForm::begin([
                'action' => '/menu/index/',
                'method' => 'get',
            ]); ?>

            <div class="searchpanel mb20">
                <div class="input-group">
                    <?= $form->field($searchModel, 'title')->label(false)->textInput(['placeholder' => 'ค้นหารายงาน...', 'label'=>false]) ?>
                    <span class="input-group-btn">
            <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-default']) ?>
          </span>
                </div>
                <!-- input-group -->
            </div>
            <?php ActiveForm::end(); ?>


        </div>
    </div>
