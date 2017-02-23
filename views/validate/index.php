<?php
$this->title = 'ตรวจสอบ Type Area';
$this->params['breadcrumbs'][] = $this->title;

use kartik\grid\GridView;
use yii\helpers\Html;

?>
<div class="content body">
    <div class="row">

        <div class="col-md-12">

            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'responsiveWrap' => false,
                'responsive' => false,
                'containerOptions' => ['style' => 'overflow: auto', 'class' => 'panel-inverse'],
                'condensed' => true,
                'hover' => true,
                'export' => ['target' => '_self'],
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> รายงานประชากรแยกตามประเภท TypeArea</h3>'],


                'columns' => [
                    ['class'=>'yii\grid\SerialColumn'],

                    ['label' => 'รหัส','attribute' => 'hospcode'],
                    ['label' => 'หน่วยบริการ','attribute' => 'hosname', 'noWrap' => true],
                    ['label' => 'อำเภอ','attribute' => 'อำเภอ'],
                    ['label' => 'Type 1','attribute' => 'typearea1'],
                    ['label' => 'Type 2','attribute' => 'typearea2'],
                    ['label' => 'Type 3','attribute' => 'typearea3'],
                    ['label' => 'Type 4','attribute' => 'typearea4'],
                    ['label' => 'Type 5','attribute' => 'typearea5'],
                    ['label' => 'ประชากรรวม','attribute' => 'sum1_3'],
                    ['label' => 'ประชากรซ้ำ','attribute' => 'repeatedly',
                        'format'=>'raw', 'value'=>function($d){ return Html::a($d['repeatedly'], ['validate/hospcode', 'hospcode'=>$d['hospcode']]);}],
                ]
            ]);
            ?>

            หมายเหตุ : <br>
            TypeArea1 = มีชื่ออยู่ตามทะเบียนบ้านในเขตรับผิดชอบและอยู่จริง <br>
            TypeArea2 = มีชื่ออยู่ตามทะเบีบนบ้านในเขตรับผิดชอบแต่ตัวไม่อยู่จริง <br>
            TypeArea3 = มาอาศัยอยู่ในเขตรับผิดชอบ(ตามทะเบียนบ้านในเขตรับผิดชอบ)แต่ทะเบียนบ้านอยู่นอกเขตรับผิดชอบ <br>
            TypeArea4 = ที่อาศัยอยู่นอกเขตรับผิดชอบและทะเบียนบ้านไม่อยู่ในเขตรับผิดชอบ เข้ามารับบริการหรือเคยอยู่ในเขตรับผิดชอบ <br>
            TypeArea5 = มาอาศัยในเขตรับผิดชอบแต่ไม่ได้อยู่ตามทะเบียนบ้านในเขตรับผิดชอบ เช่นคนเร่ร่อน ไม่มีที่พักอาศัย เป็นต้น<br>
            ประชากรซ้ำ = ประชากรที่มี TypeArea 1 และ 3 ซ้ำกันของหน่วยบริการและมี CID เหมือนกัน <br>
            ประชากรรวม = จำนวนประชากรรวมระหว่าง TypeArea 1 กับ 3 รวมกัน <br>
            HDC = จำรวนประชากรในระบบ HDC<br>
            *รวมคนไทยและต่างชาติ ไม่รวมคนเสียชีวิต ย้าย หรือสาบสูญ (DISCHARGE = 9)
        </div>

    </div>
</div>