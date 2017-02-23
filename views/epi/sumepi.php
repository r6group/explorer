<?php
use kartik\grid\GridView;
use yii\helpers\Html;
//var_dump($sumscreen);
$this->title = 'ทะเบียนวัคซีนเด็ก';
$this->params['breadcrumbs'][] = $this->title;
?>
<h2 style="margin-top: -14px;margin-bottom: 16px"><?= Html::encode($this->title)?></h2>


<div class="content body">
<div class="row">

    <div class="col-md-12">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> รายงานการสร้างเสริมภูมิคุ้มกันโรคเด็ก </h3>'],
            'hover' => true,
            'export' => ['target' => '_self'],
            //'resizableColumns' => false,
            //'pjax' => true,
            'containerOptions' => ['style' => 'overflow: auto', 'class' => 'panel-inverse'],
            'condensed' => true,
            //'headerRowOptions'=>['class'=>'inverse'],
            'responsiveWrap' => false,
            'responsive' => false,
            'columns' => [
                ['class'=>'yii\grid\SerialColumn'],
                 [
                    'label' => 'รหัสหน่วยบริการ',
                    'attribute' => 'hospcode'
                ],
                 [
                    'label' => 'หน่วยบริการ',
                    'attribute' => 'hosname'
                ],
                [
                    'label' => 'จำนวนเด็ก',
                    'attribute' => 'total',
                    'format'=>'raw',
                    'value'=>function($hospcode){
                    return Html::a($hospcode['total'], ['epi/epi', 'hospcode'=>$hospcode['hospcode']]);
                  }
                ],
              ],
            ]);
        ?>
        </div>
</div>
</div>
