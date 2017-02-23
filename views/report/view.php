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
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;




Yii::$app->view->registerCssFile('http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css', ['position' => yii\web\View::POS_HEAD]);
Yii::$app->view->registerJsFile('http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js', ['position' => yii\web\View::POS_HEAD]);

Yii::$app->view->registerJsFile(Url::to('@web/js/activeresponse.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);
Yii::$app->view->registerJsFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.css'));
$this->registerCssFile(Url::to('@web/themes/quirk/lib/animate.css/animate.css'));

if (!$embeded == '') {
    $this->registerCss('
        body {
        background-color: #ffffff;
        }
    ');
}

//ini_set('memory_limit', '512M');


if ($embeded == '') {

    $report_url = str_replace('&', '!@#', Url::current());

    $script = '';
    $i = 0;
    foreach ($fav_cat as $cat) {
        $i++;
        $script .= "var cat" . $cat['cat_id'] . " = document.getElementById('cat" . $cat['cat_id'] . "');";
        $script .= "cat" . $cat['cat_id'] . ".onclick = function() {";

        $script .= "callAR('/report/set-favorite/', 'cat_id=" . $cat['cat_id'] . "&report_title=" . $remark . "&report_url=" . $report_url . "');";


        $script .= "};";
    }

    if ($i == 0) {
        $script .= "cat0.onclick = function() {";

        $script .= "callAR('/report/set-favorite/', 'cat_id=0&report_title=" . $remark . "&report_url=" . $report_url . "');";


        $script .= "};";
    }

    Yii::$app->view->registerJs($script, yii\web\View::POS_LOAD, 'setFavorite');
}

/* @var $this yii\web\View */
$this->title = $title;
$this->params['breadcrumbs'][] = 'Reports';

?>
<?php
if ($embeded == '') {
    ?>
    <h3 style="margin-top: -14px;margin-bottom: 16px"><?= Html::encode($this->title) ?>
        <div class="btn-group pull-right">

            <button type="button" class="btn btn-danger btn-sm dropdown-toggle tooltips hide-on-print"
                    data-toggle="dropdown"
                    data-placement="top" data-original-title="Add to favorite.">
                <i class="fa fa-heart"></i> <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" role="menu">
                <?php
                $i = 0;
                foreach ($fav_cat as $cat) {
                    $i++;
                    echo '<li><a href="javascript:void(0);" id="cat' . $cat['cat_id'] . '">' . $cat['cat_name'] . '</a></li>';
                }

                echo ($i == 0) ? '<li><a href="javascript:void(0);" id="cat0">My Favorite</a></li>' : null;
                ?>


                <li class="divider"></li>
                <li><a href="#" data-toggle="modal" data-target="#myModal">Create new group</a></li>
            </ul>

        </div>
        <!-- btn-group -->
    </h3>


    <!-- Modal -->
    <div class="modal bounceIn animated" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    Content goes here...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- modal-content -->
        </div>
        <!-- modal-dialog -->
    </div><!-- modal -->

<?php
}
?>

    <div class="row" id="page-container">

        <div class="<?= ($show_tool == 1) ? 'col-md-9' : 'col-md-12' ?>">

            <div>

                <?php if ($show_table == 1) { ?>
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
                            <input type="hidden" name="embeded" value="<?= $embeded ?>">
                            <input type="hidden" name="frameid" value="<?= $frameid ?>">


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


                    <?php $form = ActiveForm::begin([
                        'action' => ['view'],
                        'method' => 'get',
                        'id' => 'link-submit'
                    ]); ?>
                    <input type="hidden" name="id" value="<?= $searchModel->id ?>">
                    <input type="hidden" name="repid" value="<?= $searchModel->repid ?>">
                    <input type="hidden" name="catid" value="<?= $searchModel->catid ?>">
                    <input type="hidden" name="embeded" value="<?= $embeded ?>">
                    <input type="hidden" name="frameid" value="<?= $frameid ?>">
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

                    <?php ActiveForm::end();

                    ?>


                    <?= GridView::widget([

                        'dataProvider' => $dataProvider,
                        'beforeHeader' => [
                            [
                                'columns' => $header
                                ,
                                //'options'=>['class'=>'skip-export'] // remove this row from export
                            ]
                        ],
//                    'afterHeader'=>[
//                        [
//                            'columns'=>$header
//                            ,
//                            //'options'=>['class'=>'skip-export'] // remove this row from export
//                        ]
//                    ],
                        'toolbar' => [

                            '{export}',
                            '{toggleData}',
                        ],
                        'striped' => true,
                        'columns' => $columns,
                        'bordered' => true,
                        'hover' => true,
//                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
                        'export' => [
                            'target' => '_self',
                            'fontAwesome' => true,
                            'options' => ['class' => 'btn btn-sm btn-warning'],
                            'icon' => 'download-alt',
                            'label' => 'Download'
                        ],
                        'toggleData' => [
                            //'target' => '_self',
                            'fontAwesome' => true,
                            'options' => ['class' => 'btn btn-sm btn-primary'],
                            //'icon' => 'download-alt',
                            'class' => 'btn btn-sm btn-primary'
                        ],
                        'resizableColumns' => false,
                        'pjax' => true,
//                    'floatHeader'=>true,
//                    'floatHeaderOptions'=>['scrollingTop'=>'50', 'top'=>50, 'zIndex'=> 10, 'autoReflow'=> true, 'floatTableClass'=> 'table'],
                        'containerOptions' => ['style' => 'overflow: auto;-webkit-overflow-scrolling:touch', 'class' => 'panel-inverse'],
                        'condensed' => true,
                        //'headerRowOptions'=>['class'=>'inverse'],
                        'showPageSummary' => true,
//                    'pageSummaryRowOptions'=>['class' => 'kv-page-summary warning','value'=>'ewrer'],
                        'responsiveWrap' => false,
                        'responsive' => false,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary panel panel-default'],
                        'panel' => [
                            'type' => GridView::TYPE_DEFAULT,
                            'heading' => '<h3 class="panel-title"><i class="fa fa-th-large"></i> ' . $remark . '</h3>',
                            'footer' =>  ($dataProvider->totalCount > $dataProvider->pagination->pageSize || !empty($report_model->note)) ? $report_model->note : false
                        ],
                    'toggleDataContainer' => ['class' => 'btn-group btn-group-sm btn-group-primary'],
                    'exportContainer' => ['class' => 'btn-group btn-group-sm'],

                    ]);
                }
                ?>



                <!--            </div>-->
                <!--            <div class="panel-body">-->
                <?php

                if ($show_chart <> 0) {
                    if (!empty($report_model->chart_x) && !empty($report_model->chart_y)) {
                        echo $this->render('_chart', [
                            'id' => 'c1',
                            'dataProvider' => $dataProvider,
                            'reportsearchmodel' => $reportsearchmodel,
                            'title' => $title,
                            'chart_type' => $report_model->chart_type,
                            'columns' => $columns,
                            'report_model' => $report_model,
                            'embeded' => $embeded,
                            'frameid' => $frameid,
                            'remark' => $remark,
                            'header' => $header,
                            'plot_line' => $plot_line,
                            'searchModel' => $searchModel,
                            'reports_in_cat' => $reports_in_cat,
                            'cat_id' => $cat_id,
                            'chart_y_field' => $chart_y_field,
                        ]);

                        if ($embeded == '') {
                            echo $this->render('_chart', [
                                'id' => 'c2',
                                'dataProvider' => $dataProvider,
                                'reportsearchmodel' => $reportsearchmodel,
                                'title' => $title,
                                'chart_type' => 3,
                                'columns' => $columns,
                                'report_model' => $report_model,
                                'embeded' => $embeded,
                                'frameid' => $frameid,
                                'remark' => $remark,
                                'header' => $header,
                                'plot_line' => $plot_line,
                                'searchModel' => $searchModel,
                                'reports_in_cat' => $reports_in_cat,
                                'cat_id' => $cat_id,
                                'chart_y_field' => $chart_y_field,
                            ]);
                        }
                    }
                }
                ?>


                <?php

                if ($embeded == '') {

                    ?>
                    <div class="btn-group hide-on-print">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                            Compare <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Compared by years</a></li>
                            <li><a href="#">Compared to mean value</a></li>
                            <li><a href="#">Compared to another health facilities</a></li>
                            <!--                        <li class="divider"></li>-->
                            <!--                        <li><a href="#">Separated link</a></li>-->
                        </ul>
                    </div>
                <?php } ?>
            </div>


            <?php
            $profile = Profile::findOne(['user_id' => $report_model->user_id]);

            if ($embeded == '') {

                ?>
                <div class="panel panel-default">
                    <div class="panel-body">


                        <i class="fa fa-clock-o"></i> <?= Yii::$app->thai->thaidate('j F Y H:i น.'); ?>
                        (Process Time: <?=number_format(Yii::getLogger()->getElapsedTime(),2)." Sec.";?>)
                        <span class="badge pull-right">

                            <i class="glyphicon glyphicon-eye-open "> </i> <?= number_format($report_model->hits) ?> </span>

                        <?= $desc ?>
                    </div>
                </div>
            <?php } ?>


            <?php
            if (($embeded == '') & (!\Yii::$app->user->isGuest)) {

                ?>
                <div class="collapse hide-on-print" id="collapseExample">
                    <div class="panel">
                        <div class="row" style="padding: 2px">


                            <div class="pull-right" style="margin-right: 22px;margin-top: 8px">
                                <i class="fa fa-clock-o"></i> ใช้เวลาประมวลผล <?= $db_time ?> วินาที
                            </div>
                            <div class="pull-left" style="margin-right: 16px;margin-left: 22px">
                                <img src="<?= $profile->FullAvatarUrl ?>" class="media-object img-circle"
                                     style="width: 34px"
                                     alt=""/>
                            </div>

                            <div class="pull-left" style="margin-right: 16px">
                                <h5>ผู้สร้างรายงาน: <?= $profile->FullName ?></h5>
                            </div>
                            <div style="padding-top: 9px;">
                                <i class="fa fa-edit"></i> Last
                                update: <?= Yii::$app->thai->thaidate('j F Y H:i น.'); ?>
                            </div>

                        </div>
            <pre>
                <code class="sql">
<?= $sql ?>
                </code>
                </pre>
                    </div>
                </div>

                <p class="hide-on-print">
                    <button class="btn btn-quirk btn-primary" type="button" data-toggle="collapse"
                            data-target="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample">
                        SQL Source
                    </button>
                    <?= Html::a('แก้ไขรายงาน', ['/menu/update', 'id' => $searchModel->repid], ['class' => 'btn btn-quirk btn-warning']) ?>

                </p>
            <?php } ?>
        </div>

        <?php
        if ($show_tool == 1) {

            ?>
            <div class="col-md-3" id="option-column">

                <?php
                if ($embeded == '') {
                    $form = ActiveForm::begin([
                        'action' => ['/menu/index'],
                        'method' => 'get',
                    ]); ?>

                    <div class="searchpanel mb20">
                        <div class="input-group">
                            <?= $form->field($reportsearchmodel, 'title')->label(false)->textInput(['placeholder' => 'ค้นหารายงาน...', 'label' => false]) ?>
                            <span class="input-group-btn">
                                <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-default']) ?>
                            </span>
                        </div>
                        <!-- input-group -->
                    </div>

                <?php
                    ActiveForm::end();
                }
                ?>



                <?php

                $form = ActiveForm::begin([
                    'action' => ['view'],
                    'method' => 'get',
                    'id' => 'search-scope',
                ]);
                echo $this->render('/report-scope/_search', [
                    'model' => $searchModel,
                    'report_model' => $report_model,
                    'form' => $form,
                    'embeded' => $embeded,
                    'frameid' => $frameid,
                    'district' => $district,
                    'subdistrict' => $subdistrict
                ]);

                ActiveForm::end();

                ?>




                <?php
                if (!$embeded) {

                    $items = [];
                    foreach ($reports_in_cat as $value) {
                        $items[] = [
                            'label' => $value->title,
                            'url' => Url::toRoute(['view', 'repid-link' => $value->id, 'cat-link' => $cat_id]),
                            'active' => (Yii::$app->getRequest()->getQueryParam('repid-link') == $value->id),

                            'icon' => 'list'
                        ];
                    }


                    echo SideNav::widget(
                        [
                            'heading' => 'ข้อมูลที่เกี่ยวข้อง',
                            'type' => SideNav::TYPE_DEFAULT,
                            'items' => $items,
                            'activeCssClass' => 'active'
                        ]
                    );


//                    echo 'sdfsdf';
//
//                    echo Text::widget([
//                        'text' => 'aaaa@gmail.com',
//                        'size' => 3,
//                        'margin' => 4,
//                        'ecLevel' => QRcode::QR_ECLEVEL_L,
//                    ]);
                }


                ?>

            </div>
            <?php
        }

        ?>

    </div>

    <script>hljs.initHighlightingOnLoad();</script>

<?php
if ($embeded <> '') {

    ?>
    <script type="text/javascript">
        parent.AdjustIframeHeight(<?= ($frameid)? $frameid : 0; ?>, document.getElementById("page-container").scrollHeight);
    </script>

<?php } ?>