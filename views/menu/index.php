<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\Profile;



/* @var $this yii\web\View */
/* @var $searchModel phi\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ผลการค้นหา';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h3><?= Html::encode($this->title) ?></h3>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'format'=>'raw', 'value'=>function($d){ return Html::a('<i class="fa fa-th-large"></i> '.$d['title'], ['/report/view', 'repid'=>$d['id']]);}

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
