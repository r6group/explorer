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

/* @var $this yii\web\View */
/* @var $searchModel app\models\FavItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Url::to('@web/js/activeresponse.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.css'));
$this->registerCssFile(Url::to('@web/themes/quirk/lib/animate.css/animate.css'));

$this->registerJsFile(Url::to('http://203.157.145.19/js/highcharts.js'), ['position' => yii\web\View::POS_HEAD]);


$this->registerCssFile('http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css', ['position' => yii\web\View::POS_HEAD]);
$this->registerJsFile('http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js', ['position' => yii\web\View::POS_HEAD]);



$i = 0;
$script= '';

foreach ($dataProvider->getModels() as $model) {
    $i++;
    $script .= "var report_item".$model['id']." = document.getElementById('report-item".$model['id']."');";
    $script .= "report_item".$model['id'].".onclick = function() {";
    $script .= "renderReport(".$model['id'].",'".$model['report_url']."&embeded=true');";
    $script .= "};";
}


$this->registerJs("
function AdjustIframeHeightOnLoad(id) { document.getElementById('form-iframe'+id).style.height = document.getElementById('form-iframe'+id).contentWindow.document.body.scrollHeight + 'px'; }
function AdjustIframeHeight(id, i) { document.getElementById('form-iframe'+id).style.height = parseInt(i) + 'px'; }


$(document).ready(function() {

    var img=new Image();
    img.src='https://upload.wikimedia.org/wikipedia/commons/b/b6/Loading_2_transparent.gif';


".$script."


function renderReport(id, url) {

            var div = $('#doc-content' + id);
            var icon = $('#report-icon' + id);


            if (div.attr('data-loaded') != 'true') {
                icon.removeClass('fa-chevron-right');
                icon.addClass('fa-chevron-down');
                div.hide();
                div.removeClass('hide');
                div.html('<iframe id=\"form-iframe'+id+'\" src=\"'+url+'&frameid='+id+'&embeded=true&show_table=1&show_tool=0&show_chart=1\" style=\"margin:0; width:1px; min-width: 100%; display:block;  height:150px; border:none; overflow:hidden;\" scrolling=\"no\" onload=\"AdjustIframeHeightOnLoad('+id+')\"></iframe>');
                div.show();
                div.attr('data-loaded', 'true');

            } else {
                    div.toggle(200);
                    if (icon.hasClass('fa-chevron-right')) {
                        icon.removeClass('fa-chevron-right');
                        icon.addClass('fa-chevron-down');
                    } else {
                        icon.removeClass('fa-chevron-down');
                        icon.addClass('fa-chevron-right');
                    }
            }
}

});
", yii\web\View::POS_END, 'my-options');
?>
<div class="fav-item-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php


    foreach ($dataProvider->getModels() as $model) {

        ?>
        <h3 style="margin-top: -10px;margin-bottom: -24px">
            <a href="javascript:void(0);" class="row report-item" id="report-item<?=$model->id?>"><i class="fa fa-chevron-right" id="report-icon<?=$model->id?>"></i> <?=$model->report_title?></a>
        </h3>
        <div class="mailcontent hide " id="doc-content<?=$model->id?>" data-loaded="false"></div>


        <?php
    }
    ?>

</div>