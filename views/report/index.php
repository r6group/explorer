<?php

use common\models\Profile;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\sidenav\SideNav;


/* @var $this yii\web\View */
$this->title = 'ข้อมูล: ' . $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>

    <h3 style="margin-top: -14px;margin-bottom: 16px"><?= Html::encode($this->title) ?></h3>

    <div class="row">

        <div class="col-md-9">


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><i class="fa fa-th-list"></i> ข้อมูล</h4>
                </div>

                <div>
                    <div class="">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'striped' => false,

                            'bordered' => false,
                            'hover' => true,
                            'responsive' => false,
                            'containerOptions' => ['style' => 'overflow: auto', 'class' => 'panel-inverse'],
                            //'condensed' => true,
                            'responsiveWrap' => false,

                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [

                                    'label' => 'ชื่อรายงาน', 'attribute' => 'title',
                                    'width'=>'100%',
                                    'format' => 'raw', 'value' => function ($d) {

//                                    $param_array = str_replace('repid-link', 'ref', urldecode(Yii::$app->request->queryString));
//                                    $param_array = str_replace('cat-link', 'ref', $param_array);
//                                    $param_array = empty($param_array) ? '' : '&' . $param_array;

                                    $param_array= '';

                                    return Html::a('<i class="fa fa-th-large"></i> '.$d['title'], Url::to(['/report/view', 'repid-link' => $d['id'], 'cat-link'=>Yii::$app->getRequest()->getQueryParam('id')]) . $param_array);

                                }

                                ],
                                [

                                    'label' => 'ผู้สร้างรายงาน', 'attribute' => 'user_id',
                                    'noWrap' => true,
                                    'width'=>'70px',
                                    'format' => 'raw', 'value' => function ($d) {




                                    return '  <img src="'.Profile::getAvatarByUserId($d['user_id']).'" title="" data-placement="top" data-toggle="tooltip" data-original-title="'.Profile::getFullNameByUserId($d['user_id']) .'" class="media-object img-circle tooltips pull-right" style="width: 18px"> <span class="badge pull_right"><i class="glyphicon glyphicon-eye-open"> </i> '.number_format($d['hits']).'</span>';

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
