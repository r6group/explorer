<?php
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
//var_dump($sumscreen);
$this->title = 'เป้าหมายคัดกรองโรคความดันโลหิตสูง';
$this->params['breadcrumbs'][] = $this->title;
?>
<h2 style="margin-top: -14px;margin-bottom: 16px"><?= Html::encode($this->title)?></h2>
<div class="content body">
<div class="row">

    <div class="col-md-12">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'hover' => true,
            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> เป้าหมายคัดกรองความดันโลหิตสูง 15 ปีขึ้นไป</h3>'],
            'responsiveWrap' => false,
            'responsive' => false,
            'containerOptions' => ['style' => 'overflow: auto', 'class' => 'panel-inverse'],
            'condensed' => true,
            'export' => ['target' => '_self'],
            'columns' => [
                //['class'=>'yii\grid\SerialColumn'],
                 [
                    'label' => 'รหัสหน่วยบริการ',
                    'attribute' => 'hospcode'
                ],
                 [
                    'label' => 'หน่วยบริการ',
                    'attribute' => 'hosname'
                ],
                [
                    'label' => 'คัดกรองแล้ว',
                    'attribute' => 'HT_screen',
                    'format'=>'raw',
                  'value'=>function($hospcode){
                    return Html::a($hospcode['HT_screen'], ['screen/htscreen', 'hospcode'=>$hospcode['hospcode']]);
                    //return '<a href="'.Yii::$app->urlManager->createUrl(['qry/province', 'provid'=>$d['provid']]).'">'.$d['provname'].'</a>';
                  }
                ],
                [
                    'label' => 'ยังไม่ได้คัดกรอง',
                    'attribute' => 'HT_No_screen',
                    'format'=>'raw',
                  'value'=>function($hospcode){
                    return Html::a($hospcode['HT_No_screen'], ['screen/htnoscreen', 'hospcode'=>$hospcode['hospcode']]);
                    //return '<a href="'.Yii::$app->urlManager->createUrl(['qry/province', 'provid'=>$d['provid']]).'">'.$d['provname'].'</a>';
                  }
                ],
              ],
            ]);
        ?>
        </div>
<!-- หมายเหตุ : <br>
    MR นับข้อมูลจากรหัสวัคซีน 073 ให้บริการตั้งแต่วันที่ 1 พ.ค. 2558 ถึง 30 ก.ย. 2558 <br>
    dTC นับข้อมูลจากรหัสวัคซีน 901 ให้บริการตั้งแต่วันที่ 1 ม.ค. 2558 ถึง 31 ก.ค. 2558<br>
    FLU นับข้อมูลจากรหัสวัคซีน 815 ให้บริการตั้งแต่วันที่ 1 พ.ค. 2558 ถึง 31 ส.ค. 2558<br> -->
</div>
</div>
