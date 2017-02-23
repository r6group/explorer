<?php

use app\models\s;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use common\models\Profile;
use kartik\widgets\DepDrop;


/* @var $this yii\web\View */
/* @var $model app\models\s */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("


    var AddressGroup = $('#address');
    var HospList = $('#hosp-list');
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
            Region.show(speed);
            break;
        case '2':
            Region.hide(speed);
            HospList.hide(speed);
            District.hide(speed);
            Subdistrict.hide(speed);
            AddressGroup.show(speed);
            break;
        case '3':
            Region.hide(speed);
            HospList.hide(speed);
            Subdistrict.hide(speed);
            AddressGroup.show(speed);
            District.show(speed);
            break;
        case '4':
            Region.hide(speed);
            HospList.hide(speed);
            AddressGroup.show(speed);
            District.show(speed);
            Subdistrict.show(speed);

            break;
        case '5':
            Region.hide(speed);
            District.hide(speed);
            Subdistrict.hide(speed);
            AddressGroup.show(speed);
            HospList.show(speed);
            break;
        case '6':
            Region.hide(speed);
            District.hide(speed);
            Subdistrict.hide(speed);
            AddressGroup.show(speed);
            HospList.show(speed);
            break;
        default:
            Region.hide(speed);
            AddressGroup.hide(speed);
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
            DateRange.show(speed);
        }
    }

$(document).ready(function() {

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

    $('#region').on('select2:unselecting', function (e) {
        $(this).select2('val', '');
        e.preventDefault();
    });


    setVisibleInput('" . $model->scope . "', 0);
    setVisibleTimeInput('" . $model->timescope . "', 0);
});

", yii\web\View::POS_END, 'setVisibleInput');

?>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title"><span class="glyphicon glyphicon-wrench"></span> ขอบเขตข้อมูล</h4>
        </div>
        <div class="panel-body">
            <div class="row">

                <div class="col-md-12">
                    <div class="col-md-2">
                        <?= $form->field($model, 'scope')->widget(Select2::classname(), [
                            'name' => 'scope',
                            'hideSearch' => true,
                            'data' => s::getAreaScope(),
                            'options' => ['onchange' => 'setVisibleInput(this.value, 500)', 'placeholder' => 'กำหนดขอบเขตข้อมูลที่จะแสดง...'],
                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                        ]); ?>
                    </div>

                    <div class="col-md-2" id="region">
                        <?= $form->field($model, 'region')->widget(Select2::classname(), [
                            'name' => 'region',
                            'hideSearch' => true,
                            'data' => s::getRegion(),
                            'options' => ['placeholder' => 'ระบุเขตสุขภาพ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>

                    <div class="col-sm-2 col-md-2" id="address">
                        <?= $form->field($model, 'province')->dropDownList(Profile::getProvinceArray(), ['id' => 'ddl-province', 'prompt' => '---- ระบุจังหวัด ----']) ?>
                    </div>
                    <div class="col-sm-2 col-md-2" id="district">

                        <?= $form->field($model, 'district')->widget(DepDrop::classname(), [
                            'options' => ['id' => 'ddl-district'],
                            'data' => $district,
                            'pluginOptions' => [
                                'depends' => ['ddl-province'],
                                'placeholder' => '----ระบุอำเภอ----',
                                'url' => Url::to(['/report/get-district'])
                            ]
                        ]); ?>


                    </div>
                    <div class="col-sm-2 col-md-2" id="subdistrict">
                        <?= $form->field($model, 'subdistrict')->widget(DepDrop::classname(), [
                            'options' => ['id' => 'ddl-subdistrict'],
                            'data' => $subdistrict,
                            'pluginOptions' => [
                                'depends' => ['ddl-province', 'ddl-district'],
                                'placeholder' => '----ระบุตำบล----',
                                'url' => Url::to(['/report/get-subdistrict'])
                            ]
                        ]); ?>
                    </div>

                    <div class="col-md-3" id="hosp-list">
                        <?= $form->field($model, 'hospcode')->widget(Select2::classname(), [
                            'data' => Profile::getHosArray($model->province),
                            'theme' => Select2::THEME_KRAJEE,
                            'hideSearch' => false,
                            'options' => ['placeholder' => '---- ระบุสถานพยาบาล ----'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]) ?>
                    </div>

                    <div class="col-md-1">
                        <?= $form->field($model, 'timescope')->widget(Select2::classname(), [
                            'name' => 'timescope',
                            'hideSearch' => true,
                            'data' => s::getTimeScope(),
                            'options' => ['onchange' => 'setVisibleTimeInput(this.value, 500)', 'placeholder' => 'กำหนดขอบเขตช่วงเวลา...'],
                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                        ]); ?>
                    </div>

                    <div class="col-sm-3 col-md-3" id="range">
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
                    <div class="col-sm-2 col-md-1" id="year">

                        <?= $form->field($model, 'govyear')->widget(Select2::classname(), [
                            'name' => 'scope',
                            'hideSearch' => true,
                            'data' => ['2559' => '2559', '2558' => '2558', '2557' => '2557', '2556' => '2556', '2555' => '2555', '2554' => '2554',],
                            'options' => ['placeholder' => 'ระบุปี...'],
                            'pluginOptions' => [
                                'allowClear' => false
                            ],
                        ]); ?>
                    </div>




                    <div class="pull-right">
                        <label class="control-label"> </label>

                        <div class="form-group">
                            <?= Html::submitButton('ดำเนินการ', ['class' => 'btn btn-warning']) ?>
                        </div>
                    </div>

                </div>
            </div>


            <input type="hidden" name="id" value="<?= $model->id ?>">
            <input type="hidden" name="repid" value="<?= $model->repid ?>">






        </div>

    </div>


