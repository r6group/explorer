<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use yii\widgets\ActiveForm;
use common\models\Profile;
use kartik\sidenav\SideNav;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use leandrogehlen\querybuilder\QueryBuilderForm;
use kartik\export\ExportMenu;


Yii::$app->view->registerCssFile('http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css', ['position' => yii\web\View::POS_HEAD]);
Yii::$app->view->registerJsFile('http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js', ['position' => yii\web\View::POS_HEAD]);


//Yii::$app->view->registerJsFile(Url::to('@web/js/activeresponse.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);
//Yii::$app->view->registerJsFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);
//
//$this->registerCssFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.css'));
//$this->registerCssFile(Url::to('@web/themes/quirk/lib/animate.css/animate.css'));

//ini_set('memory_limit', '512M');


//$report_url = str_replace('&','!@#', Url::current());
//
//$script = '';
//    $i = 0;
//foreach ($fav_cat as $cat) {
//    $i++;
//    $script .= "var cat".$cat['cat_id']." = document.getElementById('cat".$cat['cat_id']."');";
//    $script .= "cat".$cat['cat_id'].".onclick = function() {";
//
//    $script .= "callAR('/report/set-favorite/', 'cat_id=".$cat['cat_id']."&report_title=".$title."&report_url=" .$report_url ."');";
//
//
//    $script .= "};";
//}
//
//if ($i==0){
//    $script .= "cat0.onclick = function() {";
//
//    $script .= "callAR('/report/set-favorite/', 'cat_id=0&report_title=".$title."&report_url=" .$report_url ."');";
//
//
//    $script .= "};";
//}
//
//Yii::$app->view->registerJs("window.onload = function() {". $script ."}", yii\web\View::POS_END, 'setFavorite');


/* @var $this yii\web\View */
$this->title = $title;
//$this->params['breadcrumbs'][] = $this->title;
?>


<div class="page-container">
    <div class="row">

        <div class="col-md-12">


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-th-large"></i> <?= $remark ?></h3>

                </div>
                <div class="panel-body">

                    <div class="collapse mb20" id="collapseFilter">
                        <?php

                        $filter = [];

                        foreach ($columns as $column => $value) {
                            if (isset($value['attribute']) && isset($value['label'])) {
                                $filter[] = ['id' => $value['attribute'], 'label' => $value['label'], 'type' => 'string'];
                            }

                        }

                        if (!empty($filter)) {


                            QueryBuilderForm::begin([
                                'rules' => $rules,
                                'builder' => [
                                    'id' => 'query-builder',
                                    'filters' => $filter
                                ]
                            ]) ?>


                            <input type="hidden" name="id" value="<?= $searchModel->id ?>">
                            <input type="hidden" name="repid" value="<?= $searchModel->repid ?>">
                            <input type="hidden" name="catid" value="<?= $searchModel->catid ?>">


                            <input type="hidden" name="s[scope]" value="<?= $searchModel->scope ?>">
                            <input type="hidden" name="s[region]" value="<?= $searchModel->region ?>">
                            <input type="hidden" name="s[province]" value="<?= $searchModel->province ?>">
                            <input type="hidden" name="s[district]" value="<?= $searchModel->district ?>">
                            <input type="hidden" name="s[subdistrict]" value="<?= $searchModel->subdistrict ?>">
                            <input type="hidden" name="s[cup]" value="<?= $searchModel->cup ?>">
                            <input type="hidden" name="s[hospcode]" value="<?= $searchModel->hospcode ?>">
                            <input type="hidden" name="s[timescope]" value="<?= $searchModel->timescope ?>">
                            <input type="hidden" name="s[govyear]" value="<?= $searchModel->govyear ?>">
                            <input type="hidden" name="s[startdate]" value="<?= $searchModel->startdate ?>">
                            <input type="hidden" name="s[enddate]" value="<?= $searchModel->enddate ?>">


                            <?= Html::submitButton('Apply'); ?>
                            <?= Html::resetButton('Reset'); ?>

                            <?php QueryBuilderForm::end();
                        } ?>

                    </div>

                    <div class="row" style="margin-left: 0px;margin-right: 0px">
                        <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                data-target="#collapseFilter"
                                aria-expanded="false" aria-controls="collapseFilter">
                            <span class="glyphicon glyphicon-filter"></span> Filter
                        </button>
                        <div class="pull-right">


                            <?= ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => $columns,
                                'target' => ExportMenu::TARGET_SELF,
                                'encoding' => 'utf8',
                                'exportConfig' => [
                                    ExportMenu::FORMAT_TEXT => false,
                                    ExportMenu::FORMAT_PDF => false
                                ],
                                'columnSelectorOptions' => [
                                    'label' => false,
                                    'class' => 'btn btn-sm btn-warning'
                                ],
                                'fontAwesome' => true,
                                'dropdownOptions' => [
                                    'label' => 'Export All',
                                    'class' => 'btn btn-sm btn-success'
                                ]
                            ]); ?>
                        </div>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'action' => ['view'],
                        'method' => 'get',
                        'id' => 'link-submit'
                    ]); ?>
                    <input type="hidden" name="id" value="<?= $searchModel->id ?>">
                    <input type="hidden" name="repid" value="<?= $searchModel->repid ?>">
                    <input type="hidden" name="catid" value="<?= $searchModel->catid ?>">
                    <input type="hidden" name="s[scope]" id="l-scope" value="<?= $searchModel->scope ?>">
                    <input type="hidden" name="s[region]" id="l-region" value="<?= $searchModel->region ?>">
                    <input type="hidden" name="s[province]" id="l-province" value="<?= $searchModel->province ?>">
                    <input type="hidden" name="s[district]" id="l-district" value="<?= $searchModel->district ?>">
                    <input type="hidden" name="s[subdistrict]" id="l-subdistrict"
                           value="<?= $searchModel->subdistrict ?>">
                    <input type="hidden" name="s[cup]" id="l-cup" value="<?= $searchModel->cup ?>">
                    <input type="hidden" name="s[hospcode]" id="l-hospcode" value="<?= $searchModel->hospcode ?>">
                    <input type="hidden" name="s[timescope]" id="l-timescope" value="<?= $searchModel->timescope ?>">
                    <input type="hidden" name="s[govyear]" id="l-govyear" value="<?= $searchModel->govyear ?>">
                    <input type="hidden" name="s[startdate]" id="l-startdate" value="<?= $searchModel->startdate ?>">
                    <input type="hidden" name="s[enddate]" id="l-enddate" value="<?= $searchModel->enddate ?>">
                    <?= Html::submitButton('Apply', ['id' => 'filter-submit', 'style' => 'display: none;']); ?>

                    <?php ActiveForm::end(); ?>


                    <?= GridView::widget([

                        'dataProvider' => $dataProvider,
                        'striped' => true,
                        'columns' => $columns,
                        'bordered' => true,
                        'hover' => true,
                        'export' => ['target' => '_self'],
                        'resizableColumns' => false,
                        'pjax' => true,
//                    'floatHeader'=>true,
//                    'floatHeaderOptions'=>['scrollingTop'=>'50'],
                        'containerOptions' => ['style' => 'overflow: auto', 'class' => 'panel-inverse'],
                        'condensed' => true,
                        //'headerRowOptions'=>['class'=>'inverse'],
                        'showPageSummary' => true,
                        'responsiveWrap' => false,
                        'responsive' => false,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary panel panel-default'],
//                    'panel' => [
//                        'type'=>GridView::TYPE_DEFAULT,
//                        'heading' => '<h3 class="panel-title"><i class="fa fa-file"></i> ' . $remark . '</h3>',
//                        'footer' => false
//                    ],

                    ]); ?>

                </div>
                <div class="panel-body">


                    <?php


                    if (!empty($report_model->chart_x) && !empty($report_model->chart_y)) {

                        if ($report_model->chart_type == 5) {
                            $categories = [];
                            foreach ($dataProvider->models as $model) {
                                $categories[] = $model[$chart_y_field];
                            }


                            $series = [];
                            $cats = explode(',', $report_model->chart_x);
                            $fields_array = unserialize($report_model->fields);
                            foreach ($cats as $cat) {
                                $array = ArrayHelper::getValue($fields_array, $cat, []);

                                $caption = ArrayHelper::getValue($array, 'caption', $cat);
                                $caption = empty($caption) ? $cat : $caption;


                                //foreach (explode(',', $report_model->chart_x) as $value) {
                                $datas = [];
                                foreach ($dataProvider->models as $model) {
                                    $datas[] = $model[$cat] * 1;
                                }
                                $series[] = ['name' => $caption, 'data' => $datas];
                                //}

                            }

                            echo Highcharts::widget([
                                'options' => [
                                    'chart' => [
                                        'type' => 'bar'
                                    ],
                                    'title' => ['text' => false],
                                    'xAxis' => [
                                        'categories' => $categories
                                    ],
                                    'yAxis' => [
                                        'min' => 0,
                                        'title' => ['text' => $chart_y_field]
                                    ],
                                    'legend' => [
                                        'reversed' => false
                                    ],
                                    'plotOptions' => [
                                        'series' => [
                                            'stacking' => 'normal'
                                        ]
                                    ],
                                    'colors' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                                    'credits' => [
                                        'enabled' => false
                                    ],
                                    'series' => $series
                                ]
                            ]);

                        } elseif ($report_model->chart_type == 2) {

                            $categories = [];
                            foreach ($dataProvider->models as $model) {
                                $categories[] = $model[$chart_y_field];
                            }


                            $series = [];
                            $cats = explode(',', $report_model->chart_x);
                            $fields_array = unserialize($report_model->fields);
                            foreach ($cats as $cat) {
                                $array = ArrayHelper::getValue($fields_array, $cat, []);

                                $caption = ArrayHelper::getValue($array, 'caption', $cat);
                                $caption = empty($caption) ? $cat : $caption;


                                //foreach (explode(',', $report_model->chart_x) as $value) {
                                $datas = [];
                                foreach ($dataProvider->models as $model) {
                                    $datas[] = $model[$cat] * 1;
                                }
                                $series[] = ['name' => $caption, 'data' => $datas];
                                //}

                            }

                            // Bar Chart Horizontal
                            echo Highcharts::widget([
                                'options' => [
                                    'chart' => [
                                        'type' => 'bar'
                                    ],
                                    'title' => ['text' => false],
                                    'xAxis' => [
                                        'categories' => $categories
                                    ],
                                    'yAxis' => [
                                        'min' => 0,
                                        'title' => ['text' => null]
                                    ],
                                    'legend' => [
                                        'reversed' => false
                                    ],
                                    'plotOptions' => [
                                        'bar' => [
                                            'dataLabels' => ['enabled' => true]
                                        ]
                                    ],
                                    'colors' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                                    'credits' => [
                                        'enabled' => false
                                    ],
                                    'series' => $series
                                ]
                            ]);

                        } elseif ($report_model->chart_type == 6) {
                            $categories = [];
                            foreach ($dataProvider->models as $model) {
                                $categories[] = $model[$chart_y_field];
                            }


                            $series = [];
                            $cats = explode(',', $report_model->chart_x);
                            $fields_array = unserialize($report_model->fields);
                            foreach ($cats as $cat) {
                                $array = ArrayHelper::getValue($fields_array, $cat, []);

                                $caption = ArrayHelper::getValue($array, 'caption', $cat);
                                $caption = empty($caption) ? $cat : $caption;


                                //foreach (explode(',', $report_model->chart_x) as $value) {
                                $datas = [];
                                foreach ($dataProvider->models as $model) {
                                    $datas[] = $model[$cat] * 1;
                                }
                                $series[] = ['type' => 'column', 'name' => $caption, 'data' => $datas];
                                //}

                            }


                            // Bar Chart Vertical
                            echo Highcharts::widget([
                                'options' => [

                                    'title' => ['text' => false],
                                    'xAxis' => [
                                        'categories' => $categories
                                    ],
                                    'yAxis' => [
                                        'min' => 0,
                                        'title' => ['text' => null]
                                    ],
                                    'legend' => [
                                        'reversed' => false
                                    ],
                                    'plotOptions' => [
                                        'bar' => [
                                            'dataLabels' => ['enabled' => true]
                                        ]
                                    ],
                                    'colors' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                                    'credits' => [
                                        'enabled' => false
                                    ],
                                    'series' => $series
                                ]
                            ]);


                        } elseif ($report_model->chart_type == 3) {

                            $series = [];

                            foreach ($dataProvider->models as $model) {
                                $datas = 0;
                                foreach (explode(',', $report_model->chart_x) as $value) {
                                    $datas += $model[$value] * 1;
                                }

                                $series[] = ['name' => $model[$chart_y_field], 'y' => $datas];
                            }


                            // Pie Chart
                            echo Highcharts::widget([
                                'scripts' => [
                                    'modules/exporting',

                                ],
                                'options' => [
                                    'title' => [
                                        'text' => false,
                                    ],
                                    'plotOptions' => [
                                        'pie' => [
                                            'allowPointSelect' => true,
                                            'cursor' => 'pointer',
                                            'dataLabels' => [
                                                'enabled' => true,
                                                'format' => '<b>{point.name}</b>: {point.percentage:.1f} %'
                                            ]
                                        ]
                                    ],
                                    'credits' => [
                                        'enabled' => false
                                    ],
                                    'colors' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4', '#3FB52F', '#D5005D', '#DB9800', '#008FB9', '#5E6DA7', '#009886', '#4DDC3B', '#FF0000', '#FFB900', '#00AEE0', '#7385CA', '#00BAA2', '#A8E9A5',],
                                    'series' => [

                                        [
                                            'type' => 'pie',
                                            'name' => 'จำนวน',
                                            'data' =>
                                                $series
                                            ,
                                            'innerSize' => '50%',

                                            //'showInLegend' => true,
                                            'colorByPoint' => true,
                                            'dataLabels' => [
                                                'enabled' => true,
                                            ],
                                        ],
                                    ],
                                ]
                            ]);

                            //Population pyramid
                        } elseif ($report_model->chart_type == 7) {
                            $series = [];

                            foreach ($dataProvider->models as $model) {
                                $datas = 0;
                                foreach (explode(',', $report_model->chart_x) as $value) {
                                    $datas += $model[$value] * 1;
                                }

                                $series[] = ['name' => $model[$chart_y_field], 'y' => $datas];
                            }


                            $categories = ['0-4', '5-9', '10-14', '15-19',
                                '20-24', '25-29', '30-34', '35-39', '40-44',
                                '45-49', '50-54', '55-59', '60-64', '65-69',
                                '70-74', '75-79', '80-84', '85-89', '90-94',
                                '95-99', '100 + '];


                            echo Highcharts::widget([
                                'scripts' => [
                                    'modules/exporting',

                                ],
                                'options' => [
                                    'title' => [
                                        'text' => 'Population pyramid',
                                    ],
                                    'xAxis' => [
                                        'categories' => $categories
                                    ],
                                    'yAxis' => [
                                        'title' => ['text' => null],
                                    ],
                                    'plotOptions' => [
                                        'pie' => [
                                            'allowPointSelect' => true,
                                            'cursor' => 'pointer',
                                            'dataLabels' => [
                                                'enabled' => true,
                                                'format' => '<b>{point.name}</b>: {point.percentage:.1f} %'
                                            ]
                                        ]
                                    ],
                                    'credits' => [
                                        'enabled' => false
                                    ],
                                    'colors' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4', '#3FB52F', '#D5005D', '#DB9800', '#008FB9', '#5E6DA7', '#009886', '#4DDC3B', '#FF0000', '#FFB900', '#00AEE0', '#7385CA', '#00BAA2', '#A8E9A5',],
                                    'series' => [

                                        [
                                            'type' => 'pie',
                                            'name' => 'จำนวน',
                                            'data' =>
                                                $series
                                            ,
                                            'innerSize' => '50%',

                                            //'showInLegend' => true,
                                            'colorByPoint' => true,
                                            'dataLabels' => [
                                                'enabled' => true,
                                            ],
                                        ],
                                    ],
                                ]
                            ]);

                        } else {

                            $series = [];

                            foreach ($dataProvider->models as $model) {
                                $datas = [];
                                foreach (explode(',', $report_model->chart_x) as $value) {
                                    $datas[] = $model[$value] * 1;
                                }

                                $series[] = ['name' => $model[$chart_y_field], 'data' => $datas];
                            }


                            $categories = [];
                            $cats = explode(',', $report_model->chart_x);
                            $fields_array = unserialize($report_model->fields);
                            foreach ($cats as $cat) {
                                $array = ArrayHelper::getValue($fields_array, $cat, []);

                                $caption = ArrayHelper::getValue($array, 'caption', $cat);
                                $caption = empty($caption) ? $cat : $caption;
                                $categories[] = $caption;
                            }


                            echo Highcharts::widget([
                                'options' => [
                                    'title' => ['text' => false],
                                    'xAxis' => [
                                        'categories' => $categories
                                    ],
                                    'colors' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
//                        'legend' => [
//                            'layout' => 'vertical',
//                            'align' => 'right',
//                            'verticalAlign' => 'middle',
//                            'borderWidth' => 0
//                        ],
                                    'yAxis' => [
                                        'title' => ['text' => 'จำนวนรับบริการ (ครั้ง)']
                                    ],
                                    'credits' => [
                                        'enabled' => false
                                    ],
                                    'series' => $series
                                ]
                            ]);


                        }

                    }

                    ?>


                </div>

            </div>


        </div>

    </div>
</div>


<script>hljs.initHighlightingOnLoad();</script>
<script type="text/javascript">
    parent.AdjustIframeHeight(<?=$frameid?> ,document.getElementById("page-container").scrollHeight);
</script>