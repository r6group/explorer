<?php

use kpi\models\KpiList;
use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\Profile;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel kpi\models\KpiListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kpi Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kpi-list-index">


        <div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                //'tableOptions' =>['class' => 'table table-hover'],
                // parameters from the demo form
                'bordered'=>false,
                'striped'=>false,
                'condensed'=>false,
                'responsive'=>true,
                'hover'=>true,
                'floatHeader'=>true,
                'floatHeaderOptions'=>['scrollingTop'=>'50'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'title',
                    //'id',
                    'kpi_year',
                    'kpi_no',
                    'kpi_level',

                    [
                        'label' => 'ผู้รายงานข้อมูล', 'attribute' => 'reporter_id',
                        'noWrap' => true,
                        'width'=>'70px',
                        'format' => 'raw', 'value' => function ($d) {

                        if ($d['reporter_id'] <> '') {
                            return KpiList::getReporters($d['id'], '');
                        } else {
                            return $d['reporter_id'];
                        }
                    }

                    ],



                    [

                        'label' => 'ปรับปรุงผู้รายงานข้อมูล',
                        'noWrap' => true,
                        'width'=>'70px',
                        'format' => 'raw', 'value' => function ($d) {



                            return Html::a('แก้ไข', ['assign-reporter', 'id' => $d['id']]);





                    }

                    ],

                    // 'description:ntext',
                    // 'kpi_unit',
                    // 'target:ntext',
                    // 'pop_target',
                    // 'goal',
                    // 'max_value',
                    // 'method:ntext',
                    // 'data_source:ntext',
                    // 'a_unit',
                    // 'a_desc:ntext',
                    // 'b_unit',
                    // 'b_desc:ntext',
                    // 'formula:ntext',
                    // 'level_ministry:boolean',
                    // 'level_region:boolean',
                    // 'level_province:boolean',
                    // 'level_impotant:boolean',
                    // 'level_ceo_assess:boolean',
                    // 'tags:ntext',
                    // 'eval_freq:ntext',
                    // 'baseline:ntext',
                    // 'eval_rule:ntext',
                    // 'eval_method:ntext',
                    // 'doc:ntext',
                    // 'tech_support:ntext',
                    // 'director:ntext',
                    // 'reporter:ntext',
                    // 'areabase_kpi_provcode',
                    // 'areabase_kpi_regioncode',
                    // 'remark:ntext',
                    // 'last_update',

//                    ['class' => 'yii\grid\ActionColumn','contentOptions' => ['style' => 'width:70px;'],],
                ],
            ]); ?>
        </div>



</div>
