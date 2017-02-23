<?php

use app\models\s;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use common\models\Profile;



/* @var $this yii\web\View */
/* @var $model app\models\s */
/* @var $form yii\widgets\ActiveForm */

Yii::$app->view->registerJsFile(Url::to('@web/js/activeresponse.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs("


    var AddressGroup = $('#address');
    var HospList = $('#hosp-list');
    var CupList = $('#cup-list');
    var District = $('#district');
    var Subdistrict = $('#subdistrict');
    var Region = $('#region');


    function setVisibleInput(scope, speed) {
        
        switch(scope) {
        case '1':
            AddressGroup.hide(speed);
            HospList.hide(speed);
            District.hide(speed);
            Subdistrict.hide(speed);
            CupList.hide(speed);
            Region.show(speed);
            break;
        case '2':
            Region.hide(speed);
            HospList.hide(speed);
            District.hide(speed);
            Subdistrict.hide(speed);
            CupList.hide(speed);
            AddressGroup.show(speed);
            break;
        case '3':
            Region.hide(speed);
            HospList.hide(speed);
            Subdistrict.hide(speed);
            CupList.hide(speed);
            AddressGroup.show(speed);
            District.show(speed);
            break;
        case '4':
            Region.hide(speed);
            HospList.hide(speed);
            CupList.hide(speed);
            AddressGroup.show(speed);
            District.show(speed);
            Subdistrict.show(speed);

            break;
        case '5':
            Region.hide(speed);
            District.hide(speed);
            Subdistrict.hide(speed);
            HospList.hide(speed);
            AddressGroup.show(speed);
            CupList.show(speed);
            break;
        case '6':
            Region.hide(speed);
            Subdistrict.hide(speed);
            CupList.hide(speed);
            AddressGroup.show(speed);
            District.show(speed);
            HospList.show(speed);
            break;
        default:
            Region.hide(speed);
            AddressGroup.hide(speed);
            CupList.hide(speed);
            HospList.hide(speed);
            District.hide(speed);
            Subdistrict.hide(speed);
        }
    }


    var DateRange = $('#range');
    var YearList = $('#year');

   function setVisibleTimeInput(time_scope, speed) {

        switch(time_scope) {
        case '1':
            YearList.hide(speed);
            DateRange.show(speed);
            break;
        case '2':
            DateRange.hide(speed);
            YearList.show(speed);
            break;
        case '3':
            DateRange.hide(speed);
            YearList.show(speed);
            break;
        default:
            YearList.hide(speed);
            DateRange.hide(speed);
        }
    }



    setVisibleInput('" . $model->scope . "', 0);
    setVisibleTimeInput('" . $model->timescope . "', 0);


", yii\web\View::POS_END, 'setVisibleInput');


$this->registerJs("


    $('#s-province').on('select2:unselecting', function (e) {
        $(this).select2('val', '');
        e.preventDefault();
    });

    $('#s-district').on('select2:unselecting', function (e) {
        $(this).select2('val', '');
        e.preventDefault();
    });

    $('#s-subdistrict').on('select2:unselecting', function (e) {
        $(this).select2('val', '');
        e.preventDefault();
    });

    $('#s-timescope').on('select2:unselecting', function (e) {
        $(this).select2('val', '');
        e.preventDefault();
    });

    $('#s-cup').on('select2:unselecting', function (e) {
        $(this).select2('val', '');
        e.preventDefault();
    });

    $('#s-hospcode').on('select2:unselecting', function (e) {
        $(this).select2('val', '');
        e.preventDefault();
    });

    $('#s-region').on('select2:unselecting', function (e) {
        $(this).select2('val', '');
        e.preventDefault();
    });


    setVisibleInput('" . $model->scope . "', 0);
    setVisibleTimeInput('" . $model->timescope . "', 0);


", yii\web\View::POS_LOAD, 'pSelect2');


$phi_path = Yii::$app->config->get('PHI.PATH');

?>
<?php

if (!empty($report_model->area_visible) || !empty($report_model->time_visible)) {

    ?>


    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><i class="fa fa-wrench"></i> ขอบเขตข้อมูล</h4>
        </div>
        <div class="panel-body">

            <div class="row">
                <?php

                if (!empty($report_model->area_visible)) {


                    ?>
                    <div class="col-md-12">
                        <?= $form->field($model, 'scope')->widget(Select2::classname(), [
                            'name' => 'scope',
                            'hideSearch' => true,
                            'data' => s::getAreaScope(),
                            'options' => [
                                'onchange' => 'setVisibleInput(this.value, 500)',
                                'placeholder' => 'กำหนดขอบเขตข้อมูลที่จะแสดง...',
                                'options' => [
                                    1 => ['disabled' => !in_array("1", explode(',', $report_model->area_visible))],
                                    2 => ['disabled' => !in_array("2", explode(',', $report_model->area_visible))],
                                    3 => ['disabled' => !in_array("3", explode(',', $report_model->area_visible))],
                                    4 => ['disabled' => !in_array("4", explode(',', $report_model->area_visible))],
                                    5 => ['disabled' => !in_array("5", explode(',', $report_model->area_visible))],
                                    6 => ['disabled' => !in_array("6", explode(',', $report_model->area_visible))],
                                ]
                            ],
                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                        ]); ?>
                    </div>

                    <div class="col-md-12" id="region">
                        <?= $form->field($model, 'region')->widget(Select2::classname(), [
                            'name' => 'region',
                            'hideSearch' => true,
                            'data' => s::getRegion(),
                            'options' => ['placeholder' => 'ทุกเขตสุขภาพ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>

                    <div class="col-md-12" id="address">
                        <?= $form->field($model, 'province')->widget(Select2::classname(), [
                            'name' => 'province',
                            'hideSearch' => false,
                            'data' => s::getProvince(),
                            'options' => ['onchange' => 'callAR("'.$phi_path.'menu/update-district/", "prov="+this.value);', 'placeholder' => 'ทุกจังหวัด...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>


                    <div class="col-md-12" id="district">
                        <?= $form->field($model, 'district')->widget(Select2::classname(), [
                            'name' => 'district',
                            'hideSearch' => false,
                            'data' => $district,
                            'options' => ['onchange' => 'callAR("'.$phi_path.'menu/update-subdistrict/", "prov="+$("#s-province").val()+"&district="+this.value);', 'placeholder' => 'ทุกอำเภอ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>


                    <div class="col-md-12" id="subdistrict">
                        <?= $form->field($model, 'subdistrict')->widget(Select2::classname(), [
                            'name' => 'subdistrict',
                            'hideSearch' => false,
                            'data' => $subdistrict,
                            'options' => ['placeholder' => 'ทุกตำบล...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>


                    <div class="col-md-12" id="hosp-list">
                        <?= $form->field($model, 'hospcode')->widget(Select2::classname(), [
                            'data' => Profile::getHosArray($model->province, empty($model->district) ? '': substr($model->district, 2, 2)),
                            'theme' => Select2::THEME_KRAJEE,
                            'hideSearch' => false,
                            'options' => ['placeholder' => 'ทุกสถานพยาบาล...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]) ?>
                    </div>

                    <div class="col-md-12" id="cup-list">
                        <?= $form->field($model, 'cup')->widget(Select2::classname(), [
                            'data' => Profile::getCupArray($model->province),
                            'theme' => Select2::THEME_KRAJEE,
                            'hideSearch' => false,
                            'options' => ['placeholder' => 'ทุก CUP...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]) ?>
                    </div>

                    <?php
                }

                if (!empty($report_model->time_visible)) {


                    ?>

                    <div class="col-md-12">
                        <?= $form->field($model, 'timescope')->widget(Select2::classname(), [
                            'name' => 'timescope',
                            'hideSearch' => true,
                            'data' => s::getTimeScope(),
                            'options' => [
                                'onchange' => 'setVisibleTimeInput(this.value, 500)',
                                'placeholder' => 'ทุกช่วงเวลา...',
                                'options' => [
                                    1 => ['disabled' => !in_array("1", explode(',', $report_model->time_visible))],
                                    2 => ['disabled' => !in_array("2", explode(',', $report_model->time_visible))],
                                    3 => ['disabled' => !in_array("3", explode(',', $report_model->time_visible))],

                                ]
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>

                    <div class="col-sm-12 col-md-12" id="range">
                        <label class="control-label">ช่วงวันที่</label>

                        <?= DatePicker::widget([
                            'name' => 'startdate',
                            'convertFormat' => true,
                            'model' => $model,
                            'attribute' => 'startdate',
                            'attribute2' => 'enddate',
                            'type' => DatePicker::TYPE_RANGE,
                            'name2' => 'enddate',
                            'separator' => ' ถึง ',
                            'pluginOptions' => [
                                'autoclose' => true,
                                'convertFormat' => true,
                                'format' => 'd MMMM yyyy',
                                'saveSettings' => [
                                    'date' => 'php:Y-m-d',
                                    'time' => 'php:H:i:s',
                                    'datetime' => 'php:Y-m-d H:i:s',
                                ],
                                'displaySettings' => [
                                    'date' => 'd MMMM yyyy',
                                    'time' => 'hh:mm:ss',
                                    'datetime' => 'dd MMMM yyyy hh:mm:ss',
                                ],
                            ],

                        ]); ?>
                    </div>
                    <div class="col-sm-12 col-md-12" id="year">

                        <?= $form->field($model, 'govyear')->widget(Select2::classname(), [
                            'name' => 'govyear',
                            'hideSearch' => true,
                            'data' => ['2560' => '2560','2559' => '2559', '2558' => '2558', '2557' => '2557', '2556' => '2556', '2555' => '2555', '2554' => '2554',],
                            'options' => ['placeholder' => 'ระบุปี...'],
                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                        ]); ?>
                    </div>


                <?php } ?>

                <div class="col-md-12">
                    <label class="control-label"> </label>

                    <div class="form-group">
                        <?= Html::submitButton('ดำเนินการ', ['class' => 'btn btn-warning btn-quirk btn-block']) ?>
                    </div>
                    <?= $form->field($model, 'reports')->hiddenInput(['label' => '', 'value' => $model->repid])->label(false) ?>
                </div>


            </div>


            <input type="hidden" name="id" value="<?= $model->id ?>">
            <input type="hidden" name="repid" value="<?= $model->repid ?>">
            <input type="hidden" name="catid" value="<?= $model->catid ?>">
            <input type="hidden" name="embeded" value="<?= $embeded ?>">
            <input type="hidden" name="frameid" value="<?= $frameid ?>">
        </div>


    </div>

    <?php

}

?>