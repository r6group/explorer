<?php
use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'ทะเบียนวัคซีนเด็ก';
$this->params['breadcrumbs'][] = $this->title;
?>
<h2 style="margin-top: -14px;margin-bottom: 16px"><?= Html::encode($this->title.' '.$hospname)?></h2>

<div>
<div class="row">

    <div class="col-md-12">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> รายชื่อเด็ก 0-6 ปี ในเขตรับผิดชอบ ' .$hospname.'</h3>'],

            'bordered' => true,
            'hover' => true,
            'export' => ['target' => '_self'],
            //'resizableColumns' => false,
            //'pjax' => true,
            'containerOptions' => ['style' => 'overflow: auto', 'class' => 'panel-inverse'],
            'condensed' => true,
            //'headerRowOptions'=>['class'=>'inverse'],
            'responsiveWrap' => false,
            'responsive' => false,

            'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'รายชื่อเด็ก 0-6 ปี ในเขตรับผิดชอบ', 'options'=>['colspan'=>7,'class'=>'text-center' ]],
                ['content'=>'แรกเกิด', 'options'=>['colspan'=>2, 'class'=>'text-center']],
                ['content'=>' 2 เดือน', 'options'=>['colspan'=>2, 'class'=>'text-center']],
                ['content'=>' 4 เดือน', 'options'=>['colspan'=>4, 'class'=>'text-center']],
                ['content'=>' 6 เดือน', 'options'=>['colspan'=>3, 'class'=>'text-center']],
                ['content'=>' 9-12 เดือน', 'options'=>['colspan'=>2, 'class'=>'text-center']],
                ['content'=>' 18 เดือน', 'options'=>['colspan'=>2, 'class'=>'text-center']],
                ['content'=>' 2-2.5 ปี', 'options'=>['colspan'=>2, 'class'=>'text-center']],
                ['content'=>' 4-6 ปี', 'options'=>['colspan'=>2, 'class'=>'text-center']],
                // ['content'=>' 10-12 ปี', 'options'=>['colspan'=>1, 'class'=>'text-center']],
            ],
            'options'=>['class'=>'skip-export',] // remove this row from export
        ]
    ],
            'columns' => [
                ['class'=>'yii\grid\SerialColumn'],
//                 [
//                    'label' => 'HOSP',
//                    'attribute' => 'hospcode',
//                     'noWrap' => true
//                ],
//                 [
//                    'label' => 'CID',
//                    'attribute' => 'cid',
//                     'noWrap' => true
//                ],
                [
                    'label' => 'PID',
                    'attribute' => 'pid',
                    'noWrap' => true
                ],
                [
                    'label' => 'ชื่อ - นามสกุล',
                    'attribute' => 'fullname',
                    'noWrap' => true
                ],

                [
                   'label' => 'อายุ',
                   'attribute' => 'age',
                    'noWrap' => true,
                    'hAlign'=>'center'
               ],
                [
                    'label' => 'เลขที่',
                    'attribute' => 'HOUSE',
                    'noWrap' => true,
                ],
                [
                    'label' => 'หมู่',
                    'attribute' => 'VILLAGE',
                    'noWrap' => true,
                ],
                [
                    'label' => 'ชื่อมารดา',
                    'attribute' => 'MOM',
                    'noWrap' => true,
                ],

               //แรกเกิด
               [
                  'label' => 'BCG',
                  'attribute' => 'bcg_hospcode',
                   'noWrap' => true,
                   'hAlign'=>'center',
                  'format'=>'raw',
                  'value'=>function($row){
                  if ($row['bcg_hospcode'] == null) {
                    return '<i class="glyphicon glyphicon-remove">';
                  } else {
                    return $row['bcg_hospcode'];
                  }
                  }
              ],
              [
                 'label' => 'HBV1',
                 'attribute' => 'hbv1_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
                 'format'=>'raw',
                 'value'=>function($row){
                 if ($row['hbv1_hospcode'] == null) {
                   return '<i class="glyphicon glyphicon-remove">';
                 } else {
                   return $row['hbv1_hospcode'];
                 }
                 }
              ],
              //2เดือน

              [
               'label' => 'OPV1',
               'attribute' => 'opv1_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
               'format'=>'raw',
               'value'=>function($row){
               if ($row['opv1_hospcode'] == null) {
                 return '<i class="glyphicon glyphicon-remove">';
               } else {
                 return $row['opv1_hospcode'];
               }
               }
              ],
              [
              'label' => 'DTP1',
              'attribute' => 'dtp1_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['dtp1_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['dtp1_hospcode'];
              }
              }
              ],
              //4เดือน
              [
                'label' => 'HBV2',
                'attribute' => 'hbv1_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
                'format'=>'raw',
                'value'=>function($row){
                if ($row['hbv1_hospcode'] == null) {
                  return '<i class="glyphicon glyphicon-remove">';
                } else {
                  return $row['hbv1_hospcode'];
                }
                }
              ],
              [
              'label' => 'OPV2',
              'attribute' => 'opv2_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['opv2_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['opv2_hospcode'];
              }
              }
              ],
              [
              'label' => 'DTP2',
              'attribute' => 'dtp2_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['dtp2_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['dtp2_hospcode'];
              }
              }
              ],
              [
              'label' => 'IPV2',
              'attribute' => 'ipv2_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['ipv2_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['ipv2_hospcode'];
              }
              }
              ],
              //6เดือน
              [
              'label' => 'HBV3',
              'attribute' => 'hbv3_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['hbv3_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['hbv3_hospcode'];
              }
              }
              ],
              [
              'label' => 'OPV3',
              'attribute' => 'opv3_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['opv3_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['opv3_hospcode'];
              }
              }
              ],
              [
              'label' => 'DTP3',
              'attribute' => 'dtp3_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['dtp3_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['dtp3_hospcode'];
              }
              }
              ],
              //9เดือน
              [
              'label' => 'MMR1',
              'attribute' => 'mmr1_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['mmr1_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['mmr1_hospcode'];
              }
              }
              ],
              //12เดือน
              [
              'label' => 'LA-JE1',
              'attribute' => 'je1_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['je1_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['je1_hospcode'];
              }
              }
              ],
              //18เดือน
              [
              'label' => 'DTP4',
              'attribute' => 'dtp4_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['dtp4_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['dtp4_hospcode'];
              }
              }
              ],
              [
              'label' => 'OPV4',
              'attribute' => 'opv4_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['opv4_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['opv4_hospcode'];
              }
              }
              ],

              //2.5ปี
              [
              'label' => 'MMR2',
              'attribute' => 'mmr2_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['mmr2_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['mmr2_hospcode'];
              }
            }
              ],
              [
              'label' => 'LA-JE2',
              'attribute' => 'je2_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['je2_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['je2_hospcode'];
              }
              }
              ],
              //4-6 ปี
              [
              'label' => 'DTP5',
              'attribute' => 'dtp5_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['dtp5_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['dtp5_hospcode'];
              }
              }
              ],
              [
              'label' => 'OPV5',
              'attribute' => 'opv5_hospcode',
                  'noWrap' => true,
                  'hAlign'=>'center',
              'format'=>'raw',
              'value'=>function($row){
              if ($row['opv5_hospcode'] == null) {
                return '<i class="glyphicon glyphicon-remove">';
              } else {
                return $row['opv5_hospcode'];
              }
              }
              ],

            ]
        ]);
        ?>
        </div>

</div>
</div>
