<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Health Profile';
//$this->params['loginform'][] = true;
$this->params['breadcrumbs'][] = $this->title;


//Yii::$app->view->registerJsFile(Url::to('@web/js/map.shiftworker.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);
Yii::$app->view->registerJsFile(Url::to('@web/themes/quirk/lib/jquery-sparkline/jquery.sparkline.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);
Yii::$app->view->registerJsFile(Url::to('http://maps.google.com/maps/api/js?sensor=true'), ['position' => yii\web\View::POS_HEAD]);

Yii::$app->view->registerJsFile(Url::to('@web/themes/quirk/lib/gmaps/gmaps.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);



$this->registerJsFile(Url::to('@web/js/activeresponse.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.css'));
$this->registerCssFile(Url::to('@web/themes/quirk/lib/animate.css/animate.css'));

$this->registerJsFile(Url::to('http://203.157.145.19/js/highcharts.js'), ['position' => yii\web\View::POS_HEAD]);


$this->registerCssFile('http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/default.min.css', ['position' => yii\web\View::POS_HEAD]);
$this->registerJsFile('http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js', ['position' => yii\web\View::POS_HEAD]);


$this->registerJs("

    function AdjustIframeHeightOnLoad(id) { document.getElementById('form-iframe'+id).style.height = document.getElementById('form-iframe'+id).contentWindow.document.body.scrollHeight + 'px'; }
    function AdjustIframeHeight(id, i) { document.getElementById('form-iframe'+id).style.height = parseInt(i) + 'px'; }



", yii\web\View::POS_HEAD, 'iframe');

$map_js = "";
if ($scope == 6 && !empty($models_hos->h_latitude)) {
    $map_js = "
$(function() {

  'use strict';

   var styleShiftWorker = [{
    \"featureType\": \"administrative\",
    \"elementType\": \"all\",
    \"stylers\": [{
      \"visibility\": \"on\"
    }, {
      \"lightness\": 33
    }]
  }, {
    \"featureType\": \"administrative\",
    \"elementType\": \"labels\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }]
  }, {
    \"featureType\": \"administrative\",
    \"elementType\": \"labels.text\",
    \"stylers\": [{
      \"gamma\": \"0.75\"
    }]
  }, {
    \"featureType\": \"administrative.neighborhood\",
    \"elementType\": \"labels.text.fill\",
    \"stylers\": [{
      \"lightness\": \"-37\"
    }]
  }, {
    \"featureType\": \"landscape\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"color\": \"#f9f9f9\"
    }]
  }, {
    \"featureType\": \"landscape.man_made\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }, {
      \"lightness\": \"40\"
    }, {
      \"visibility\": \"off\"
    }]
  }, {
    \"featureType\": \"landscape.natural\",
    \"elementType\": \"labels.text.fill\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }, {
      \"lightness\": \"-37\"
    }]
  }, {
    \"featureType\": \"landscape.natural\",
    \"elementType\": \"labels.text.stroke\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }, {
      \"lightness\": \"100\"
    }, {
      \"weight\": \"2\"
    }]
  }, {
    \"featureType\": \"landscape.natural\",
    \"elementType\": \"labels.icon\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }]
  }, {
    \"featureType\": \"poi\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }, {
      \"lightness\": \"80\"
    }]
  }, {
    \"featureType\": \"poi\",
    \"elementType\": \"labels\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }, {
      \"lightness\": \"0\"
    }]
  }, {
    \"featureType\": \"poi.attraction\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"lightness\": \"-4\"
    }, {
      \"saturation\": \"-100\"
    }]
  }, {
    \"featureType\": \"poi.park\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"color\": \"#c5dac6\"
    }, {
      \"visibility\": \"on\"
    }, {
      \"saturation\": \"-95\"
    }, {
      \"lightness\": \"62\"
    }]
  }, {
    \"featureType\": \"poi.park\",
    \"elementType\": \"labels\",
    \"stylers\": [{
      \"visibility\": \"on\"
    }, {
      \"lightness\": 20
    }]
  }, {
    \"featureType\": \"road\",
    \"elementType\": \"all\",
    \"stylers\": [{
      \"lightness\": 20
    }]
  }, {
    \"featureType\": \"road\",
    \"elementType\": \"labels\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }, {
      \"gamma\": \"1.00\"
    }]
  }, {
    \"featureType\": \"road\",
    \"elementType\": \"labels.text\",
    \"stylers\": [{
      \"gamma\": \"0.50\"
    }]
  }, {
    \"featureType\": \"road\",
    \"elementType\": \"labels.icon\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }, {
      \"gamma\": \"0.50\"
    }]
  }, {
    \"featureType\": \"road.highway\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"color\": \"#c5c6c6\"
    }, {
      \"saturation\": \"-100\"
    }]
  }, {
    \"featureType\": \"road.highway\",
    \"elementType\": \"geometry.stroke\",
    \"stylers\": [{
      \"lightness\": \"-13\"
    }]
  }, {
    \"featureType\": \"road.highway\",
    \"elementType\": \"labels.icon\",
    \"stylers\": [{
      \"lightness\": \"0\"
    }, {
      \"gamma\": \"1.09\"
    }]
  }, {
    \"featureType\": \"road.arterial\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"color\": \"#e4d7c6\"
    }, {
      \"saturation\": \"-100\"
    }, {
      \"lightness\": \"47\"
    }]
  }, {
    \"featureType\": \"road.arterial\",
    \"elementType\": \"geometry.stroke\",
    \"stylers\": [{
      \"lightness\": \"-12\"
    }]
  }, {
    \"featureType\": \"road.arterial\",
    \"elementType\": \"labels.icon\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }]
  }, {
    \"featureType\": \"road.local\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"color\": \"#fbfaf7\"
    }, {
      \"lightness\": \"77\"
    }]
  }, {
    \"featureType\": \"road.local\",
    \"elementType\": \"geometry.fill\",
    \"stylers\": [{
      \"lightness\": \"-5\"
    }, {
      \"saturation\": \"-100\"
    }]
  }, {
    \"featureType\": \"road.local\",
    \"elementType\": \"geometry.stroke\",
    \"stylers\": [{
      \"saturation\": \"-100\"
    }, {
      \"lightness\": \"-15\"
    }]
  }, {
    \"featureType\": \"transit.station.airport\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"lightness\": \"47\"
    }, {
      \"saturation\": \"-100\"
    }]
  }, {
    \"featureType\": \"water\",
    \"elementType\": \"all\",
    \"stylers\": [{
      \"visibility\": \"on\"
    }, {
      \"color\": \"#acbcc9\"
    }]
  }, {
    \"featureType\": \"water\",
    \"elementType\": \"geometry\",
    \"stylers\": [{
      \"saturation\": \"53\"
    }]
  }, {
    \"featureType\": \"water\",
    \"elementType\": \"labels.text.fill\",
    \"stylers\": [{
      \"lightness\": \"-42\"
    }, {
      \"saturation\": \"17\"
    }]
  }, {
    \"featureType\": \"water\",
    \"elementType\": \"labels.text.stroke\",
    \"stylers\": [{
      \"lightness\": \"61\"
    }]
  }];

  var mapBasic2 = new GMaps({
    el: '#mapBasic2',
    zoom: 14,
    lat: ".$models_hos->h_latitude.",
    lng: ".$models_hos->h_longitude."
  });

  mapBasic2.addStyle({
    styledMapName:\"Shift Worker Map\",
    styles: styleShiftWorker,
    mapTypeId: \"map_shift_worker\"
  });

  mapBasic2.setStyle(\"map_shift_worker\");

  mapBasic2.addMarker({
    lat: ".$models_hos->h_latitude.",
    lng: ".$models_hos->h_longitude."
  });
});";
}

$this->registerJs("

    function renderReport(id, url) {
            var div = $('#doc-content' + id);


            if (div.attr('data-loaded') != 'true') {

                div.hide();
                div.removeClass('hide');
                div.html('<iframe id=\"form-iframe'+id+'\" src=\"'+url+'&frameid='+id+'&embeded=true\" style=\"margin:0; width:1px; min-width: 100%; display:block; height: 100px; border:none; overflow:auto;\" scrolling=\"no\" onload=\"AdjustIframeHeightOnLoad('+id+')\"></iframe>');
                div.show();
                div.attr('data-loaded', 'true');
            } else {
                div.toggle(200);
            }
}



renderReport(0,'".Url::to(['report/view', 'repid-link'=>'33', 'frameid' => '0', 'embeded'=>'true', 'show_table'=>'1', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//ประชากร 
renderReport(1,'".Url::to(['report/view', 'repid-link'=>'136', 'frameid' => '1', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//ป่วย
 renderReport(2,'".Url::to(['report/view', 'repid-link'=>'138', 'frameid' => '2', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//ตาย
 renderReport(3,'".Url::to(['report/view', 'repid-link'=>'211', 'frameid' => '3', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//'คลอดมีชีพ15-19ปี' 
renderReport(4,'".Url::to(['report/view', 'repid-link'=>'220', 'frameid' => '4', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//พัฒนาการเด็ก
 renderReport(5,'".Url::to(['report/view', 'repid-link'=>'127', 'frameid' => '5', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//EPI 1 ปี 
renderReport(6,'".Url::to(['report/view', 'repid-link'=>'133', 'frameid' => '6', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//EPI 2 ปี 
renderReport(7,'".Url::to(['report/view', 'repid-link'=>'134', 'frameid' => '7', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//EPI 3 ปี 
renderReport(8,'".Url::to(['report/view', 'repid-link'=>'135', 'frameid' => '8', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//EPI 5 ปี 
renderReport(9,'".Url::to(['report/view', 'repid-link'=>'63', 'frameid' => '9', 'embeded'=>'true', 'show_table'=>'1', 'show_tool'=>'0', 'show_chart'=>'0'],true)."');//บุคลากร 
renderReport(10,'".Url::to(['report/view', 'repid-link'=>'141', 'frameid' => '10', 'embeded'=>'true', 'show_table'=>'1', 'show_tool'=>'0', 'show_chart'=>'0'],true)."');//อสม.
 renderReport(11,'".Url::to(['report/view', 'repid-link'=>'140', 'frameid' => '11', 'embeded'=>'true', 'show_table'=>'1', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//สิทธิ์.
 renderReport(12,'".Url::to(['report/view', 'repid-link'=>'214', 'frameid' => '12', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//anc ก่อน 12 wks.. 
renderReport(13,'".Url::to(['report/view', 'repid-link'=>'215', 'frameid' => '13', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//โลหิตจาง
renderReport(14,'".Url::to(['report/view', 'repid-link'=>'219', 'frameid' => '14', 'embeded'=>'true', 'show_table'=>'0', 'show_tool'=>'0', 'show_chart'=>'1'],true)."');//นักเรียนอ้วน

    /***** SPARKLINE CHARTS *****/

    $('#sparkline').sparkline([4,3,3,1,4,3,2,2,3], {
        type: 'bar',
        height:'30px',
        barColor: '#428BCA'
    });

    $('#sparkline2').sparkline([4,3,3,1,4,3,2,2,3], {
        type: 'line',
        height:'33px',
        width: '50px',
        lineColor: false,
        fillColor: '#1CAF9A'
    });

    $('#sparkline3').sparkline([4,3,3,1,4,3,2,2,3], {
        type: 'pie',
        height:'33px',
        sliceColors: ['#F0AD4E','#428BCA','#D9534F','#1CAF9A','#5BC0DE']
    });

    $('#sparkline4').sparkline([4,3,3,5,4,3,2,5,3], {
        type: 'line',
        height:'33px',
        width: '50px',
        lineColor: '#5BC0DE',
        fillColor: false
    });

    $('#sparkline4').sparkline([3,6,6,2,6,5,3,2,1], {
        type: 'line',
        height:'33px',
        width: '50px',
        lineColor: '#D9534F',
        fillColor: false,
        composite: true
    });


".$map_js, yii\web\View::POS_LOAD, 'sparkline');


?>



<h2>Health Profile: <?=$locate?></h2>

<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div>

            <div class="panel panel-map-location">
                <?= ($scope == 6 && !empty($models_hos->h_latitude))? '<div id="mapBasic2" class="map-wrapper"></div>' : '' ?>

                <div class="panel-body">
                    <div class="media">
                        <div class="media-left">
                            <img src="<?=Url::to('@web/images/healthcare.png')?>" class="width80" alt="Company Logo">
                        </div>
                        <div class="media-body">
                            <address>
                                <strong><?=$locate?></strong>
                                <?= ($scope == 6 && !empty($models_hos->address))? $models_hos->address : '' ?>

                               <br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                        </div><!-- media-body -->
                    </div><!-- media -->

                    <div class="btn-group pull-left">
                        <button class="btn btn-primary" type="button"><i class="fa fa-phone mr5"></i> Call</button>
                        <button class="btn btn-primary" type="button"><i class="fa fa-envelope mr5"></i> Email</button>
                    </div>

                    <div class="btn-group pull-right">
                        <button class="btn btn-success" type="button"><i class="fa fa-star mr5"></i> 4.2 Rating</button>
                    </div>

                </div><!-- panel-body -->
            </div><!-- panel -->

        </div><!-- col-md-4 -->
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title panel-title-alt">Sparkline Charts </h4>
                <p><a href="http://omnipotent.net/jquery.sparkline" target="_blank">jQuery Sparkline</a> generates sparklines (small inline charts) directly in the browser using data supplied either inline in the HTML, or via javascript. </p>
            </div><!-- panel-heading -->
            <div class="panel-body">

                <div class="tinystat mr20">
                    <div id="sparkline" class="chart mt5"></div>
                    <div class="datainfo">
                        <span class="spark-caption">จำนวนผู้ป่วยนอก</span>
                        <h4>$630,201</h4>
                    </div>
                </div><!-- tinystat -->

                <div class="tinystat mr20">
                    <div id="sparkline2" class="chart mt5"></div>
                    <div class="datainfo">
                        <span class="text-muted">Avg Sales</span>
                        <h4>$106,850</h4>
                    </div>
                </div><!-- tinystat -->

                <div class="tinystat mr20">
                    <div id="sparkline3" class="chart mt5">1,5,3,6,8,2</div>
                    <div class="datainfo">
                        <span class="text-muted">Avg Order</span>
                        <h4>23,001,090</h4>
                    </div>
                </div><!-- tinystat -->

                <div class="tinystat">
                    <div id="sparkline4" class="chart mt5">1,5,3,6,8,2</div>
                    <div class="datainfo">
                        <span class="text-muted">Avg Expenses</span>
                        <h4>$11,090</h4>
                    </div>
                </div><!-- tinystat -->

            </div><!-- panel-body -->
        </div><!-- panel -->

        <?= ($scope == 6)? '<div class="mailcontent hide mb20" id="doc-content9" data-loaded="false"></div>' : '' ?>


        <div class="mailcontent hide mb20" id="doc-content0" data-loaded="false"></div>
        <div class="mailcontent hide mb20" id="doc-content11" data-loaded="false"></div>

        <?= ($scope == 6)? '<div class="mailcontent hide mb20" id="doc-content10" data-loaded="false"></div>' : '' ?>


        <div class="mailcontent hide mb20" id="doc-content1" data-loaded="false"></div>

        <div class="mailcontent hide mb20" id="doc-content2" data-loaded="false"></div>

    </div>


    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">

            <?php $form = ActiveForm::begin([
                'action' => ['/menu/index'],
                'method' => 'get',
            ]); ?>

            <div class="searchpanel mb20">
                <div class="input-group">
                    <?= $form->field($searchModel, 'title')->label(false)->textInput(['placeholder' => 'ค้นหารายงาน...', 'label' => false]) ?>
                    <span class="input-group-btn">
            <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-default']) ?>
          </span>
                </div>
                <!-- input-group -->
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        </div>

        <div class="timeline-wrapper">
            <div class="timeline-date">การฝากครรภ์ การคลอด และเด็กเล็ก</div>

            <div class="panel panel-post-item status">
                <div class="panel-heading">
                    <div class="media">

                        <div class="media-body">
                            <h4 class="media-heading">การฝากครรภ์</h4>
                            <p class="media-usermeta">

                                <i class="glyphicon glyphicon-map-marker"></i> <a href="">San Francisco, CA</a>
                            </p>
                        </div>
                    </div><!-- media -->
                    <ul class="panel-options">
                        <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                    </ul>
                </div><!-- panel-heading -->
                <div class="panel-body">
                    <div class="mailcontent hide " id="doc-content13" data-loaded="false"></div>
                    <div class="mailcontent hide " id="doc-content12" data-loaded="false"></div>
                </div>
                <div class="panel-footer">
                    <ul class="list-inline">
                        <li><a href=""><i class="glyphicon glyphicon-heart"></i> Like</a></li>
                        <li><a data-target="#comment-1" data-toggle="collapse"><i class="glyphicon glyphicon-comment"></i> Comments (2)</a></li>
                        <li class="pull-right">24 liked this</li>
                    </ul>
                </div>
                <div class="collapse" id="comment-1">
                    <ul class="media-list">
                        <li class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img-circle" src="../images/photos/user2.png" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Floyd M. Romero <small>8 minutes ago</small></h4>
                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.
                            </div>
                        </li>
                        <li class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img-circle" src="../images/photos/user3.png" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Jennie S. Gray <small>5 minutes ago</small></h4>
                                Nor again is there anyone who loves or pursues or desires to obtain pain of itself,
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Write some comments">
                </div>
            </div><!-- panel panel-post -->

            <div class="panel panel-post-item status">
                <div class="panel-heading">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">การคลอด และการดูแลหลังคลอด</h4>
                            <p class="media-usermeta">
                                <i class="glyphicon glyphicon-map-marker"></i> <a href="">Sydney, Australia</a>
                            </p>
                        </div>
                    </div><!-- media -->
                    <ul class="panel-options">
                        <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                    </ul>
                </div><!-- panel-heading -->
                <div class="panel-body">
                <div class="mailcontent hide " id="doc-content3" data-loaded="false"></div>

                </div>

                <div class="panel-footer">
                    <ul class="list-inline">
                        <li><a href=""><i class="glyphicon glyphicon-heart"></i> Like</a></li>
                        <li><a><i class="glyphicon glyphicon-comment"></i> Comments (0)</a></li>
                        <li class="pull-right">5 liked this</li>
                    </ul>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Write some comments">
                </div>
            </div><!-- panel panel-post -->

            <div class="panel panel-post-item commented">
                <div class="panel-heading">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">การได้รับวัคซีนและพัฒนาการเด็กเล็ก <span>commented on this</span></h4>
                            <p class="media-usermeta">
                                <i class="glyphicon glyphicon-map-marker"></i> <a href="">Tokyo, Japan</a>
                            </p>
                        </div>
                    </div><!-- media -->
                    <ul class="panel-options">
                        <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                    </ul>
                </div><!-- panel-heading -->
                <div class="panel-body">
                    <div class="media">

                        <div class="media-body">
                            <div class="mailcontent hide " id="doc-content4" data-loaded="false"></div>
                            <div class="mailcontent hide " id="doc-content5" data-loaded="false"></div>
                            <div class="mailcontent hide " id="doc-content6" data-loaded="false"></div>
                            <div class="mailcontent hide " id="doc-content7" data-loaded="false"></div>
                            <div class="mailcontent hide " id="doc-content8" data-loaded="false"></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <ul class="list-inline">
                        <li><a href=""><i class="glyphicon glyphicon-heart"></i> Like</a></li>
                        <li><a data-target="#comment-2" data-toggle="collapse"><i class="glyphicon glyphicon-comment"></i> Comments (1)</a></li>
                        <li class="pull-right">2 liked this</li>
                    </ul>
                </div>
                <div class="collapse" id="comment-2">
                    <ul class="media-list">
                        <li class="media">
                            <div class="media-body">
                                <h4 class="media-heading">Jennie S. Gray <small>8 minutes ago</small></h4>
                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Write some comments">
                </div>
            </div><!-- panel panel-post -->



            <div class="timeline-date">เด็กวัยเรียน</div>

            <div class="panel panel-post-item twitter">
                <div class="panel-heading">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">ร้อยละของเด็กนักเรียนมีภาวะเริ่มอ้วนและอ้วน <span>shared a tweet</span></h4>
                            <p class="media-usermeta">
                                <i class="glyphicon glyphicon-map-marker"></i> <a href="">Bali, Indonesia</a>
                            </p>
                        </div>
                    </div><!-- media -->
                    <ul class="panel-options">
                        <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                    </ul>
                </div><!-- panel-heading -->
                <div class="panel-body">
                    <div class="mailcontent hide " id="doc-content14" data-loaded="false"></div>
                </div>
            </div><!-- panel panel-post -->

            <div class="timeline-date">เด็กวัยรุ่น</div>

            <div class="panel panel-post-item twitter">
                <div class="panel-heading">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">ความชุกของภาวะอ้วน <span>shared a tweet</span></h4>
                            <p class="media-usermeta">
                                <i class="glyphicon glyphicon-map-marker"></i> <a href="">Bali, Indonesia</a>
                            </p>
                        </div>
                    </div><!-- media -->
                    <ul class="panel-options">
                        <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                    </ul>
                </div><!-- panel-heading -->
                <div class="panel-body">
                    //
                </div>
            </div><!-- panel panel-post -->


            <div class="timeline-date">วัยทำงาน</div>

            <div class="panel panel-post-item twitter">
                <div class="panel-heading">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">โรคจากการประกอบอาชีพ <span>shared a tweet</span></h4>
                            <p class="media-usermeta">
                                <i class="glyphicon glyphicon-map-marker"></i> <a href="">Bali, Indonesia</a>
                            </p>
                        </div>
                    </div><!-- media -->
                    <ul class="panel-options">
                        <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                    </ul>
                </div><!-- panel-heading -->
                <div class="panel-body">
                   //
                </div>
            </div><!-- panel panel-post -->


            <div class="timeline-date">ผู้สูงอายุและผู้พิการ</div>

            <div class="panel panel-post-item twitter">
                <div class="panel-heading">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">ผู้สูงอายุ<span>shared a tweet</span></h4>
                            <p class="media-usermeta">
                                <i class="glyphicon glyphicon-map-marker"></i> <a href="">Bali, Indonesia</a>
                            </p>
                        </div>
                    </div><!-- media -->
                    <ul class="panel-options">
                        <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                    </ul>
                </div><!-- panel-heading -->
                <div class="panel-body">
             //
                </div>
            </div><!-- panel panel-post -->

            <div class="panel panel-post-item commented">
                <div class="panel-heading">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">ผู้พิการ<span>published a new article</span></h4>
                            <p class="media-usermeta">
                                <i class="glyphicon glyphicon-map-marker"></i> <a href="">Sacramento, CA, USA</a>
                            </p>
                        </div>
                    </div><!-- media -->
                    <ul class="panel-options">
                        <li><a class="tooltips" href="" data-toggle="tooltip" title="View Options"><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                    </ul>
                </div><!-- panel-heading -->
                <div class="panel-body">
                    <div class="media">
                        <div class="media-body">
                            //
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <ul class="list-inline">
                        <li><a href=""><i class="glyphicon glyphicon-heart"></i> Like</a></li>
                        <li><a><i class="glyphicon glyphicon-comment"></i> Comments (0)</a></li>
                        <li class="pull-right">18 liked this</li>
                    </ul>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Write some comments">
                </div>
            </div><!-- panel panel-post -->

            <div class="timeline-date"></div>

        </div><!-- timeline-wrapper -->
    </div>

</div><!-- row -->