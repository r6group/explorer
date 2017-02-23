<?php

use yii\helpers\Html;
use kartik\grid\GridView;
//use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model app\models\Checktype */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Checktypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <div class="checktype-view">
        <h2><?= Html::encode($this->title) ?>รายละเอียด</h2>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> รายงานประชากร TypeArea 1,3 ซ้ำหน่วยบริการ</h3>'],
            'responsiveWrap' => false,
            'responsive' => false,
            'hover' => true,
            'export' => ['target' => '_self'],
            'containerOptions' => ['style' => 'overflow: auto', 'class' => 'panel-inverse'],
            'resizableColumns' => false,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'CID',
                    'attribute' => 'CID'
                ],
                [
                    'label' => 'ชื่อ - นามสกุล',
                    'attribute' => 'FULLNAME'
                ],
                // [
                //     'label' => 'นามสกุล',
                //     'attribute' => 'LNAME'
                // ],
                [
                    'label' => 'TYPE AREA',
                    'attribute' => 'TYPEAREA'
                ],
                [
                    'label' => 'PID',
                    'attribute' => 'PID'
                ],
                 [
                     'label' => 'HOSPCODE',
                     'attribute' => 'HOSPCODE'
                 ],
                [
                    'label' => 'ชื่อหน่วยบริการ',
                    'attribute' => 'HOSNAME'
                ],
                [
                    'label' => 'บ้านเลขที่',
                    'attribute' => 'HOUSENO'
                ],
                [
                    'label' => 'หมู่ที่',
                    'attribute' => 'VILLAGE'
                ],
                [
                    'label' => 'ตำบล',
                    'attribute' => 'TAMBON'
                ],
                [
                    'label' => 'อำเภอ',
                    'attribute' => 'AMPUR'
                ],
                [
                    'label' => 'จังหวัด',
                    'attribute' => 'CHANGWAT'
                ],
                [
                    'label' => 'วันที่ปรับปรุงข้อมูล',
                    'attribute' => 'D_UPDATE'
                ],




                // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

        หมายเหตุ : <br>
        TypeArea1 = มีชื่ออยู่ตามทะเบียนบ้านในเขตรับผิดชอบและอยู่จริง <br>
        TypeArea3 = มาอาศัยอยู่ในเขตรับผิดชอบ(ตามทะเบียนบ้านในเขตรับผิดชอบ)แต่ทะเบียนบ้านอยู่นอกเขตรับผิดชอบ <br>
    </div>


</div>

