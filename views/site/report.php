<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
$this->title = 'Report';
?>
<div class="site-index">


    <div class="body-content">

        <?=GridView::widget([

            'dataProvider'=>$dataProvider ,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'msg',
            ],
            'responsive'=>true,

            'showPageSummary' => false,


        ]);?>

    </div>
</div>
