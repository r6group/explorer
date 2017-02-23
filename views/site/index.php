<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Health Explorer';
//$this->params['loginform'][] = true;
//$this->params['breadcrumbs'][] = $this->title;


//$this->registerCssFile(Url::to('@web/themes/quirk/lib/weather-icons/css/weather-icons.css'));

?>

<ul class="nav nav-warning nav-tabs nav-line nav-line-inverse">
    <li<?=($active_tab == '') ? ' class="active"' : ''?>><a href="#explorer" aria-controls="explorer" data-toggle="tab" role="tab"><i
                class="fa fa-square-o"></i> <strong>Health Explorer</strong></a></li>
    <li<?=($active_tab == 'profile') ? ' class="active"' : ''?>><a href="#profile" data-toggle="tab" aria-controls="profile" role="tab"><i class="fa fa-medkit"></i> <strong>Health
                Profile</strong></a></li>
    <li<?=($active_tab == 'kpi') ? ' class="active"' : ''?>><a href="#kpi" data-toggle="tab" aria-controls="kpi" role="tab"><i class="fa fa-stethoscope"></i>
            <strong>KPI</strong></a></li>

</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane<?=($active_tab == '') ? ' active in' : ''?> fade" id="explorer">


        <div class="row">
            <div class="col-md-9 col-lg-8 dash-left">


                <div class="row panel-quick-page">
                    <div class="col-xs-4 col-sm-5 col-md-4 page-user">

                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '59']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">ANC</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><span class="icon-i-labor-delivery"
                                                                 aria-hidden="true"></span></div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 page-products">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">New Born</h4>
                            </div>
                            <div class="panel-body">
                                <div class="page-icon"><span class="icon-i-nursery" aria-hidden="true"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2 page-events">
                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '62']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">EPI</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><span class="icon-i-immunizations" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2 page-messages">
                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '51']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Chronic</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><i class="fa fa-heartbeat"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-5 col-md-2 page-reports">
                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '63']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Service</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><i class="icon ion-arrow-graph-up-right"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2 page-statistics">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">Allergy</h4>
                            </div>
                            <div class="panel-body">
                                <div class="page-icon"><span class="icon-i-pharmacy" aria-hidden="true"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 page-support">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">Disability</h4>
                            </div>
                            <div class="panel-body">
                                <div class="page-icon"><i class="fa fa-wheelchair"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2 page-privacy">
                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '74']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Diag</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><i class="fa fa-hospital-o"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2 page-settings">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">Accident</h4>
                            </div>
                            <div class="panel-body">
                                <div class="page-icon"><i class="fa fa-ambulance"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-5 col-md-4 page-user">

                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '63']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">OPD</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><span class="icon-i-outpatient" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <div class="col-xs-4 col-sm-3 col-md-2 page-messages">
                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '63']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">IPD</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><i class="fa fa-pie-chart"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 page-products">
                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '58']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">NCD Screen</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><i class="fa fa-user-md"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-5 col-md-2 page-reports">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">Nutrition</h4>
                            </div>
                            <div class="panel-body">
                                <div class="page-icon"><span class="icon-i-nutrition" aria-hidden="true"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-3 col-md-2 page-events">
                        <div class="panel">
                            <a href="<?= Url::toRoute('site/calendar') ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Labor</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><i class="fa fa-hotel"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2 page-statistics">
                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '76']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Death</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><i class="fa fa-plus-square"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 page-support">
                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '64']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Dental</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><span class="icon-i-dental" aria-hidden="true"></span></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2 page-privacy">
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">Prenatal</h4>
                            </div>
                            <div class="panel-body">
                                <div class="page-icon"><i class="fa fa-stethoscope"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2 page-settings">
                        <div class="panel">
                            <a href="<?= Url::toRoute(['/report/index', 'id' => '57']) ?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Epidem</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="page-icon"><span class="icon-i-infectious-diseases"
                                                                 aria-hidden="true"></span></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- row -->


            </div>
            <!-- col-md-9 -->
            <div class="col-md-3 col-lg-4 dash-right">
                <div class="row">


                    <!-- col-md-12 -->
                    <div class="col-sm-6 col-md-12 col-lg-6">

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

                    <div class="row panel-quick-page col-sm-6 col-md-12 col-lg-6 ">
                        <div class="page-statistics">
                            <div class="panel">
                                <a href="http://zone6.cbo.moph.go.th/backoffice/hrm/default/report">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">ระบบทรัพยากรทางการแพทย์</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="page-icon"><i class="icon ion-person-stalker"></i></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-6 col-md-12 col-lg-6">
                        <div class="panel panel-primary-full">
                            <div class="panel-heading">
                                <h4 class="panel-title">Join Our Newsletter</h4>

                                <p>Sign up to get an updates to our awesome community using our personalized
                                    newsletter!</p>
                            </div>
                            <div class="panel-body">
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           placeholder="Please enter your email address">
                  <span class="input-group-btn">
                    <button class="btn btn-default btn-warning" type="button">Subscribe</button>
                  </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- col-md-12 -->
            </div>
            <!-- row -->


        </div>
        <!-- col-md-3 -->
    </div>

    <div class="tab-pane<?=($active_tab == 'profile') ? ' active in' : ''?> fade" id="profile">

        <p class="mb15">เลือกเขตพื้นที่ หรือหน่วยบริการเพื่อดูข้อมูลสุขภาพจากด้านล่างนี้.</p>
        <h3 class="mb20"><?=Html::a('<i class="fa fa-medkit"></i> จังหวัดสระแก้ว (Area Based)', ['/site/health-profile', 'lock_locate' => 'yes', 'scope' => 2, 'province' => '27', 'district' => '01'])?></h3>

        <div class="row">
            <div class="col-md-4 col-sm-6">
                <h4 class="panel-title mb5">อำเภอ (Area Based)</h4>

                <div class="panel-group" id="accordion3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion3" href="#collapseOne3">
                                    อำเภอ
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne3" class="panel-collapse collapse in">
                            <div class="panel-body">

                                <ul class="nav nav-pills nav-stacked nav-healthprofile">


                                    <?php

                                    if (!empty($models)) {
                                        foreach ($models as $row) {
                                            echo '<li>'.Html::a('<i class="fa fa-medkit"></i> อ.'. $row->ampurname, ['/site/health-profile', 'lock_locate' => 'yes', 'scope' => 3, 'province' => $row->changwatcode, 'district' => $row->ampurcodefull]) . '</li>';

                                        }
                                    }

                                    ?>
                                </ul>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- col-md-4 -->

            <div class="col-md-4 col-sm-6">
                <h4 class="panel-title mb5">ตำบล (Area Based)</h4>

                <div class="panel-group" id="accordion4">
                    <?php

                    if (!empty($models_tambon)) {
                    $district = '';
                    foreach ($models_tambon as $row) {
                    if ($district <> $row->ampurcode){
                    if ($district <> '') {
                        echo '</div></div></div>';
                    }
                    $district = $row->ampurcode;
                    ?>


                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="collapsed" data-parent="#accordion4" href="#collapseTambon<?=$row->ampurcode?>">
                                    <?='อำเภอ '.common\models\CDistrict::getDistrictName($row->ampurcode)?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTambon<?=$row->ampurcode?>" class="panel-collapse collapse">
                            <div class="panel-body">

                                <ul class="nav nav-pills nav-stacked nav-healthprofile">



                                    <?php
                                    }
                                    echo '<li>'.Html::a('<i class="fa fa-medkit"></i> ['.$row->tamboncodefull. '] ต.'.$row->tambonname, ['/site/health-profile', 'lock_locate' => 'yes', 'scope' => 4,'province' => $row->changwatcode, 'district' => $row->ampurcode, 'subdistrict' => $row->tamboncodefull]) . '</li>';

                                    }



                                    }

                                    ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col-md-4 -->

            <div class="col-md-4 col-sm-6">
                <h4 class="panel-title mb5">หน่วยบริการ (Hospital Based)</h4>

                <div class="panel-group" id="accordion5">
                    <?php

                    if (!empty($models_hos)) {
                    $district = '';
                    foreach ($models_hos as $row) {
                    if ($district <> $row->distcode){
                    if ($district <> '') {
                        echo '</div></div></div>';
                    }
                    $district = $row->distcode;
                    ?>


                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="collapsed" data-parent="#accordion5" href="#collapseHos<?=$row->provcode.$row->distcode?>">
                                    <?='อำเภอ '.common\models\CDistrict::getDistrictName($row->provcode.$row->distcode)?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseHos<?=$row->provcode.$row->distcode?>" class="panel-collapse collapse">
                            <div class="panel-body">

                                <ul class="nav nav-pills nav-stacked nav-healthprofile">



                                    <?php
                                    }
                                    echo '<li>'.Html::a('<i class="fa fa-medkit"></i> ['.$row->hoscode. '] '.$row->hosname, ['/site/health-profile', 'lock_locate' => 'yes', 'scope' => 6, 'hospcode'=>$row->hoscode, 'province' => $row->provcode, 'district' => $row->provcode.$row->distcode]) . '</li>';

                                    }



                                    }

                                    ?>
                                </ul>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- col-md-4 -->
        </div>
    </div>


    <div class="tab-pane<?=($active_tab == 'kpi') ? ' active in' : ''?> fade" id="kpi">
        <h3>Key Performance Indicator.</h3>
    </div>


</div>