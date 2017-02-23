<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ChecktypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//var_dump($querytype);
//$this->title = 'รายงานประชากร TypeArea 1,3 ซ้ำหน่วยบริการ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content body">
    <div class="checktype-index">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <!--     <p>
        <?= Html::a('Create Checktype', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'responsiveWrap' => false,
            'hover' => true,
            'responsive' => false,
            'export' => ['target' => '_self'],
            'containerOptions' => ['style' => 'overflow: auto', 'class' => 'panel-inverse'],
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> รายงานประชากร TypeArea 1,3 ซ้ำหน่วยบริการ</h3>'],
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'PID',
                [
                    'label' => 'CID', 'attribute' => 'CID',
                    'format'=>'raw', 'value'=>function($d){ return Html::a($d['CID'], ['validate/persondulp', 'HOSPCODE'=>$d['HOSPCODE'], 'CID'=>$d['CID']]);}
                ],
                'NAME',
                'LNAME',
                'TYPEAREA',
                'HOUSENO',
                'VILLAGE',
                'TAMBON',
                'AMPUR',
                'CHANGWAT',
                'HOSPCODE_T',
                'D_UPDATE'

                // ['class' => 'yii\grid\ActionColumn'],

            ],
        ]); ?>


        หมายเหตุ : <br>
        TypeArea1 = มีชื่ออยู่ตามทะเบียนบ้านในเขตรับผิดชอบและอยู่จริง <br>
        TypeArea3 = มาอาศัยอยู่ในเขตรับผิดชอบ(ตามทะเบียนบ้านในเขตรับผิดชอบ)แต่ทะเบียนบ้านอยู่นอกเขตรับผิดชอบ <br>


    </div>

</div>
