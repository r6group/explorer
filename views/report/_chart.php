<?php

use miloschuman\highcharts\Highcharts;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use miloschuman\highcharts\SeriesDataHelper;


?>

<div class="panel panel-default">

    <div class="panel panel-body panel-chart">
        <div>


            <?php


            $series_y1 = [];
            $series_y2 = [];
            $series_y3 = [];
            $series_y4 = [];
            $min=1;
            $max=20;


            if (!empty($report_model->chart_x) && !empty($report_model->chart_y)) {

                if ($chart_type == 5) {
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

                        if (strpos($caption, '|') !== false) {

                            $caption = explode('|', $caption)[1];
                        }

                        //foreach (explode(',', $report_model->chart_x) as $value) {
                        $datas = [];

                        $datas_y1 = [];
                        $datas_y2 = [];
                        $datas_y3 = [];
                        $datas_y4 = [];
                        foreach ($dataProvider->models as $model) {
                            $datas[] = $model[$cat] * 1;

                            $datas_y1[] = $model[$cat]+ rand($min,$max);
                            $datas_y2[] = $model[$cat]+ rand($min,$max);
                            $datas_y3[] = $model[$cat]+ rand($min,$max);
                            $datas_y4[] = $model[$cat]+ rand($min,$max);
                        }
                        $series[] = ['name' => $caption, 'data' => $datas];

                        $series_y1[] = ['name' => $caption, 'data' => $datas_y1];
                        $series_y2[] = ['name' => $caption, 'data' => $datas_y2];
                        $series_y3[] = ['name' => $caption, 'data' => $datas_y3];
                        $series_y4[] = ['name' => $caption, 'data' => $datas_y4];
                        //}

                    }
                    //Bar Stack
                    echo Highcharts::widget([
                        'id' => $id,
                        'setupOptions' => [
                            'lang' => [
                                'thousandsSep' => ','
                            ],
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'column'
                            ],
                            'title' => ['text' => $remark],
                            'xAxis' => [
                                'categories' => $categories
                            ],
                            'yAxis' => [
                                'min' => 0,
                                'title' => ['text' => $chart_y_field],

                            ],
                            'legend' => [
                                'reversed' => false
                            ],

                            'plotOptions' => [
                                'series' => [
                                    'stacking' => 'normal',
                                    'dataLabels' => [
                                        'enabled'=> false,
                                    ]
                                ]


                            ],
                            'colors' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                            'credits' => [
                                'enabled' => false
                            ],
                            'series' => $series
                        ]
                    ]);

                } elseif ($chart_type == 2) {

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

                        if (strpos($caption, '|') !== false) {

                            $caption = explode('|', $caption)[1];
                        }
                        //foreach (explode(',', $report_model->chart_x) as $value) {
                        $datas = [];

                        $datas_y1 = [];
                        $datas_y2 = [];
                        $datas_y3 = [];
                        $datas_y4 = [];
                        foreach ($dataProvider->models as $model) {
                            $datas[] = $model[$cat] * 1;

                            $datas_y1[] = $model[$cat]+ rand($min,$max);
                            $datas_y2[] = $model[$cat]+ rand($min,$max);
                            $datas_y3[] = $model[$cat]+ rand($min,$max);
                            $datas_y4[] = $model[$cat]+ rand($min,$max);
                        }
                        $series[] = ['name' => $caption, 'data' => $datas];
                        //}
                        $series_y1[] = ['name' => $caption, 'data' => $datas_y1];
                        $series_y2[] = ['name' => $caption, 'data' => $datas_y2];
                        $series_y3[] = ['name' => $caption, 'data' => $datas_y3];
                        $series_y4[] = ['name' => $caption, 'data' => $datas_y4];
                    }

                    // Bar Chart Horizontal
                    echo Highcharts::widget([
                        'id' => $id,
                        'setupOptions' => [
                            'lang' => [
                                'thousandsSep' => ','
                            ],
                        ],
                        'options' => [
                            'chart' => [
                                'type' => 'bar'
                            ],
                            'title' => ['text' => $remark],
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

                } elseif ($chart_type == 6) {
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

                        if (strpos($caption, '|') !== false) {

                            $caption = explode('|', $caption)[1];
                        }
                        //foreach (explode(',', $report_model->chart_x) as $value) {
                        $datas = [];

                        $datas_y1 = [];
                        $datas_y2 = [];
                        $datas_y3 = [];
                        $datas_y4 = [];
                        foreach ($dataProvider->models as $model) {
                            $datas[] = $model[$cat] * 1;

                            $datas_y1[] = $model[$cat]+ rand($min,$max);
                            $datas_y2[] = $model[$cat]+ rand($min,$max);
                            $datas_y3[] = $model[$cat]+ rand($min,$max);
                            $datas_y4[] = $model[$cat]+ rand($min,$max);
                        }
                        $series[] = ['type' => 'column', 'name' => $caption, 'data' => $datas];
                        //}
                        $series_y1[] = ['name' => $caption, 'data' => $datas_y1];
                        $series_y2[] = ['name' => $caption, 'data' => $datas_y2];
                        $series_y3[] = ['name' => $caption, 'data' => $datas_y3];
                        $series_y4[] = ['name' => $caption, 'data' => $datas_y4];
                    }


                    // Bar Chart Vertical
                    echo Highcharts::widget([
                        'id' => $id,
                        'setupOptions' => [
                            'lang' => [
                                'thousandsSep' => ','
                            ],
                        ],
                        'options' => [

                            'title' => ['text' => $remark],
                            'xAxis' => [
                                'categories' => $categories
                            ],
                            'yAxis' => [
                                'min' => 0,
                                'title' => ['text' => null],
                                'plotLines' => $plot_line

                            ],
                            'legend' => [
                                'reversed' => false
                            ],
                            'plotOptions' => [
                                'bar' => [
                                    'dataLabels' => ['enabled' => true]
                                ],
                                'series'=> [
                                    'dataLabels' => [
                                        'enabled'=> true,
                                        //'formatter'=> 'function() {return this.point.t};'
                                    ]
                                ]
                            ],
                            'colors' => ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                            'credits' => [
                                'enabled' => false
                            ],
                            'series' => $series
                        ]
                    ]);


                } elseif ($chart_type == 3) {

                    $series = [];

                    foreach ($dataProvider->models as $model) {
                        $datas = 0;


                        foreach (explode(',', $report_model->chart_x) as $value) {
                            $datas += $model[$value] * 1;

                            $datas_y1[] = $model[$value]+ rand($min,$max);
                            $datas_y2[] = $model[$value]+ rand($min,$max);
                            $datas_y3[] = $model[$value]+ rand($min,$max);
                            $datas_y4[] = $model[$value]+ rand($min,$max);
                        }

                        $series[] = ['name' => $model[$chart_y_field], 'y' => $datas];

                        $series_y1[] = ['name' => $model[$chart_y_field], 'data' => $datas_y1];
                        $series_y2[] = ['name' => $model[$chart_y_field], 'data' => $datas_y2];
                        $series_y3[] = ['name' => $model[$chart_y_field], 'data' => $datas_y3];
                        $series_y4[] = ['name' => $model[$chart_y_field], 'data' => $datas_y4];
                    }


                    // Pie Chart
                    echo Highcharts::widget([
                        'id' => $id,
                        'setupOptions' => [
                            'lang' => [
                                'thousandsSep' => ','
                            ],
                        ],
                        'scripts' => [
                            'modules/exporting',

                        ],
                        'options' => [
                            'title' => [
                                'text' => $remark,
                            ],
                            'plotOptions' => [
                                'pie' => [
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'dataLabels' => [
                                        'enabled' => true,
                                        'format' => '<b>{point.name}</b>: {point.percentage:.1f}'
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
                } elseif ($chart_type == 7) {
                    $series = [];

                    foreach ($dataProvider->models as $model) {
                        $datas = 0;

                        $datas_y1 = 0;
                        $datas_y2 = 0;
                        $datas_y3 = 0;
                        $datas_y4 = 0;
                        foreach (explode(',', $report_model->chart_x) as $value) {
                            $datas += $model[$value] * 1;

                            $datas_y1 += $model[$value]+ rand($min,$max);
                            $datas_y2 += $model[$value]+ rand($min,$max);
                            $datas_y3 += $model[$value]+ rand($min,$max);
                            $datas_y4 += $model[$value]+ rand($min,$max);
                        }

                        $series[] = ['name' => $model[$chart_y_field], 'y' => $datas];

                        $series_y1[] = ['name' => $model[$chart_y_field], 'data' => $datas_y1];
                        $series_y2[] = ['name' => $model[$chart_y_field], 'data' => $datas_y2];
                        $series_y3[] = ['name' => $model[$chart_y_field], 'data' => $datas_y3];
                        $series_y4[] = ['name' => $model[$chart_y_field], 'data' => $datas_y4];
                    }


                    $categories = ['0-4', '5-9', '10-14', '15-19',
                        '20-24', '25-29', '30-34', '35-39', '40-44',
                        '45-49', '50-54', '55-59', '60-64', '65-69',
                        '70-74', '75-79', '80-84', '85-89', '90-94',
                        '95-99', '100 + '];


                    echo Highcharts::widget([
                        'id' => $id,
                        'setupOptions' => [
                            'lang' => [
                                'thousandsSep' => ','
                            ],
                        ],
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
                                        'format' => '<b>{point.name}</b>: {point.percentage:.1f}'
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

                        $datas_y1 = [];
                        $datas_y2 = [];
                        $datas_y3 = [];
                        $datas_y4 = [];
                        foreach (explode(',', $report_model->chart_x) as $value) {
                            $datas[] = $model[$value] * 1;

                            $datas_y1[] = $model[$value]+ rand($min,$max);
                            $datas_y2[] = $model[$value]+ rand($min,$max);
                            $datas_y3[] = $model[$value]+ rand($min,$max);
                            $datas_y4[] = $model[$value]+ rand($min,$max);
                        }

                        $series[] = ['name' => $model[$chart_y_field], 'data' => $datas];

                        $series_y1[] = ['name' => $model[$chart_y_field], 'data' => $datas_y1];
                        $series_y2[] = ['name' => $model[$chart_y_field], 'data' => $datas_y2];
                        $series_y3[] = ['name' => $model[$chart_y_field], 'data' => $datas_y3];
                        $series_y4[] = ['name' => $model[$chart_y_field], 'data' => $datas_y4];
                    }


                    $categories = [];
                    $cats = explode(',', $report_model->chart_x);
                    $fields_array = unserialize($report_model->fields);
                    foreach ($cats as $cat) {
                        $array = ArrayHelper::getValue($fields_array, $cat, []);

                        $caption = ArrayHelper::getValue($array, 'caption', $cat);
                        $caption = empty($caption) ? $cat : $caption;

                        if (strpos($caption, '|') !== false) {

                            $caption = explode('|', $caption)[1];
                        }

                        $categories[] = $caption;
                    }


                    echo Highcharts::widget([
                        'id' => $id,
                        'setupOptions' => [
                            'lang' => [
                                'thousandsSep' => ','
                            ],
                        ],
                        'options' => [
                            'title' => ['text' => $remark],
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
                                'title' => ['text' => '']
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
