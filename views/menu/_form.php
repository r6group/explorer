<?php

use app\models\s;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;
use wbraganca\tagsinput\TagsinputWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
Yii::$app->view->registerJsFile(Url::to('@web/js/activeresponse.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);
Yii::$app->view->registerJsFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);

Yii::$app->view->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);



$this->registerCssFile(Url::to('@web/themes/quirk/lib/jquery.gritter/jquery.gritter.css'));
$this->registerCssFile(Url::to('@web/themes/quirk/lib/animate.css/animate.css'));


Yii::$app->view->registerJs("
jQuery.fn.extend({
insertAtCaret: function(myValue){
    return this.each(function(i) {
        if (document.selection) {
            //For browsers like Internet Explorer
            this.focus();
            var sel = document.selection.createRange();
            sel.text = myValue;
            this.focus();
        }
        else if (this.selectionStart || this.selectionStart == '0') {
            //For browsers like Firefox and Webkit based
            var startPos = this.selectionStart;
            var endPos = this.selectionEnd;
            var scrollTop = this.scrollTop;
            this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
            this.focus();
            this.selectionStart = startPos + myValue.length;
            this.selectionEnd = startPos + myValue.length;
            this.scrollTop = scrollTop;
        } else {
            this.value += myValue;
            this.focus();
        }
    });
}
});

var select2Obj = $('select');
select2Obj.select2();

/* The following mess is a result of Select2's behavior of triggering the
 * opening event twice upon unselecting an item. */
select2Obj.on('select2:unselecting', function(e) {
    $(this).data('unselecting1', true);
    $(this).data('unselecting2', true);
});
select2Obj.on('select2:open', function(e) {
    var unselecting1 = $(this).data('unselecting1');
    var unselecting2 = $(this).data('unselecting2');

    if(unselecting1 || unselecting2) {
        $(this).select2('close');

        if(unselecting1) {
            $(this).data('unselecting1', false);
        } else {
            $(this).data('unselecting2', false);
        }
    }
});




                            var citynames = new Bloodhound({
                                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                                queryTokenizer: Bloodhound.tokenizers.whitespace,
                                prefetch: {
                                    url: 'http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/assets/citynames.json',
                                    filter: function(list) {
                                        return $.map(list, function(cityname) {
                                            return { name: cityname }; });
                                    }
                                }
                            });

                            citynames.initialize();

                            $('tagsinput').tagsinput({
                                typeaheadjs: {
                                    name: 'citynames',
                                    displayKey: 'name',
                                    valueKey: 'name',
                                    source: citynames.ttAdapter()
                                }
                            });


", yii\web\View::POS_END, 'setVisibleInput');

$phi_path = Yii::$app->config->get('PHI.PATH');
?>
<?php $form = ActiveForm::begin(); ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        if ($("#report-query_type").val() == "1") {
            $("#sql").hide(200);
        } else {
            $("#sql").show(200);
        }
    });
</script>
<div class="row">


    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">

                <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#table" data-toggle="tab">Auto report</a></li>
                    <li><a href="#locate" data-toggle="tab">ขอบเขตข้อมูล</a></li>
                    <li><a href="#grid" data-toggle="tab">ตาราง</a></li>
                    <li><a href="#chart" data-toggle="tab">Chart</a></li>
                    <li><a href="#template" data-toggle="tab">HTML Template</a></li>
                    <li><a href="#permission" data-toggle="tab">Permission</a></li>
                    <li><a href="#note" data-toggle="tab">หมายเหตุ</a></li>

                </ul>

                <div class="tab-content mb20">
                    <div class="tab-pane active" id="table">
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'query_type')->widget(Select2::classname(), [
                                    'name' => 'query_type',
                                    'hideSearch' => true,
                                    'data' => ['1' => 'Table', '2' => 'SQL'],
                                    'options' => ['onchange' => 'callAR("'.$phi_path.'menu/load-fields/", "table="+$("#report-table_name").val()+"&query_type="+this.value + "&db=" + $("#report-db_name").val()); if (this.value == "1") { $("#sql").hide(200);} else {$("#sql").show(200);$("#fields-containner").html("")} ', 'placeholder' => 'ระบุวิธีประมวลผล...'],
                                    'pluginOptions' => [
                                        'allowClear' => false
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'db_name')->widget(Select2::classname(), [
                                    'name' => 'db_name',
                                    'hideSearch' => true,
                                    'data' => $user_db,
                                    'options' => ['onchange' => '$("#field-title").html("Fields: "); callAR("'.$phi_path.'menu/load-tables/", "db="+this.value);', 'placeholder' => 'ระบุฐานข้อมูล...'],
                                    'pluginOptions' => [
                                        'allowClear' => false
                                    ],
                                ]); ?>
                            </div>

                            <div class="col-md-3">
                                <?= $form->field($model, 'table_name')->widget(Select2::classname(), [
                                    'name' => 'table_name',
                                    'hideSearch' => false,
                                    'data' => $tables,
                                    'options' => ['onchange' => '$("#field-title").html("Fields: " + this.value); callAR("'.$phi_path.'menu/load-fields/", "table="+this.value+"&db="+ $("#report-db_name").val() +"&query_type="+$("#report-query_type").val());', 'placeholder' => 'ระบุ Table...'],
                                    'pluginOptions' => [
                                        'allowClear' => false
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'list_style')->widget(Select2::classname(), [
                                    'name' => 'list_style',
                                    'hideSearch' => true,
                                    'data' => ['0' => 'Group ข้อมูลอัตโนมัติ', '1' => 'แสดงรายการทั้งหมด'],
                                    'options' => ['placeholder' => 'ระบุรูปแบบ...'],
                                    'pluginOptions' => [
                                        'allowClear' => false
                                    ],
                                ]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" id="sql" style="display: none;">
                                <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label" for="report-sql" id="field-title">Fields</label>

                                    <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 10px">
                                        <div style="display: none" id="fields-list">

                                        </div>
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle pull-right" data-toggle="dropdown">
                                            SQL Template <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="javascript:void(0)" onclick="$('#report-sql').val('SELECT\n    *\nFROM\n    ' + $('#report-table_name').val() + '\nWHERE\n    ');">SELECT * FROM WHERE</a></li>
                                            <li><a href="javascript:void(0)" onclick="$('#report-sql').val('SELECT' + $('#fields-list').html() + '\nFROM\n    ' + $('#report-table_name').val() + '\nWHERE\n    ');">SELECT field1, field2, ... FROM WHERE</a></li>

                                        </ul>


                                    </div>
                                        </div>

                                    <div  style="height: 300px; overflow: scroll" id="sql-fields">

                                    </div>
                                </div>
                                <div class="col-md-9">


                                <?= $form->field($model, 'sql')->textarea(['rows' => 18, 'onchange'=>'$("#fields-containner").html("")']) ?>

                                    <div class="nomargin " style="margin-top: -16px">
                                        <span class="btn btn-sm btn-primary mb20" onclick="$('#sql-msg').remove();var sql = $('#report-sql').val(); callAR('<?=$phi_path?>menu/load-sql-fields/', 'sql='+sql.replace(/\+/gi, ' #plus#  ') + '&db='+ $('#report-db_name').val());"><i class="fa fa-play"></i> Test</span>
                                    </div>
                                </div>
                                    </div>

                            </div>
                        </div>

                        <h4>Field properties</h4>
                        <div
                            style="background-color: #FFF;padding-bottom: 8px;border-bottom: 2px solid #BDC3D1;margin-bottom: 8px;">
                            <div class="row">
                                <div class="col-md-2">
                                    Field name

                                </div>

                                <div class="col-md-1">
                                    Display
                                </div>
                                <div class="col-md-2">
                                    Caption
                                </div>
                                <div class="col-md-2">
                                    Formula
                                </div>

                                <div class="col-md-2">
                                    <div class="row">
                                    <div class="col-md-2">


                                        <i title="" data-placement="top" data-toggle="tooltip" class="fa fa-lock tooltips" data-original-title="ซ่อนข้อมูลส่วนบุคคล"></i>

                                    </div>
                                    <div class="col-md-10">
                                        Function
                                    </div>
                                        </div>
                                </div>
                                <div class="col-md-2">
                                    Display Format
                                </div>
                                <div class="col-md-1">
                                    Format Attribute
                                </div>
                            </div>
                        </div>
                        <div id="fields-containner" class="mb20">
                            <?php
                            // var_dump($model->fields_param);

                            $i = 0;
                            foreach ($columns as $column => $value) {
                                $i++;

                                //$array = ArrayHelper::getValue($model->fields_param,$value,[]);
                                ?>
                                <div
                                    style="background-color: #FFF;padding: 8px 8px 0 8px;border: 1px solid #BDC3D1;margin-bottom: 4px;border-radius:4px">
                                    <div class="row">
                                        <div class="col-md-2" style="margin-top: 10px;height: 18px">
                                            <?= $i ?>. <?= $value ?>

                                        </div>

                                        <div class="col-md-1" style="text-align: center; margin-top: 8px;height: 18px">
                                            <?= $form->field($model, 'fields_param[' . $value . '][display]')->checkbox(['label' => 'แสดง']) ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= $form->field($model, 'fields_param[' . $value . '][caption]')->textInput(['label' => false, 'maxlength' => 255])->label(false) ?>

                                        </div>
                                        <div class="col-md-2">
                                            <?= $form->field($model, 'fields_param[' . $value . '][formula]')->textInput(['label' => false, 'maxlength' => 255])->label(false) ?>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="row">


                                            <div class="col-md-2">
                                                <i class="fa fa-lock"><?= $form->field($model, 'fields_param[' . $value . '][phi]')->checkbox(['label' => '']) ?>
                                                </i>
                                            </div>
                                            <div class="col-md-10">
                                                <?= $form->field($model, 'fields_param[' . $value . '][function]')->widget(Select2::classname(), [
                                                    'name' => 'fields_param[' . $value . '][function]',
                                                    //'label'=>'Function',
                                                    'hideSearch' => true,
                                                    'data' => ['' => 'NONE', 'count' => 'COUNT()', 'sum' => 'SUM()', 'avg' => 'AVG()', 'min' => 'MIN()', 'max' => 'MAX()', 'formula' => 'FORMULA()'],
                                                    'options' => ['label' => false, 'placeholder' => 'No function'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ])->label(false); ?>
                                            </div>
                                            </div>

                                        </div>

                                        <div class="col-md-2">
                                            <?= $form->field($model, 'fields_param[' . $value . '][format]')->widget(Select2::classname(), [
                                                'name' => 'fields_param[' . $value . '][format]',
                                                //'label'=>'Function',
                                                'hideSearch' => true,
                                                'data' => ['text' => 'ตัวอักษร', 'number' => 'จำนวนเต็ม', 'decimal' => 'เลขทศนิยม', 'date' => 'วันที่', 'html' => 'HTML'],
                                                'options' => ['onchange' => '$("#report-fields_param-' . $value . '-format_val").prop("disabled", (this.value == "text" || this.value == "number" || this.value == ""))', 'label' => false, 'placeholder' => 'Not specific'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label(false); ?>
                                        </div>
                                        <div class="col-md-1">
                                            <?= $form->field($model, 'fields_param[' . $value . '][format_val]')->textInput(['label' => false, 'maxlength' => 255, 'disabled' => isset($model->fields_param[$value]['format']) && ($model->fields_param[$value]['format'] <> 'decimal' && $model->fields_param[$value]['format'] <> 'date' && $model->fields_param[$value]['format'] <> 'html')])->label(false) ?>

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                        <h4>Group by</h4>

                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'group_0')->widget(Select2::classname(), [
                                    'name' => 'group_0',
                                    'hideSearch' => true,
                                    'data' => $columns,
                                    'options' => ['placeholder' => 'No group'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>

                            <div class="col-md-3">
                                <?= $form->field($model, 'order_by')->widget(Select2::classname(), [
                                    'name' => 'group_2',
                                    'hideSearch' => true,
                                    'data' => $columns,
                                    'options' => ['placeholder' => 'No Sort'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'order_direction')->widget(Select2::classname(), [
                                    'name' => 'order_direction',
                                    'hideSearch' => true,
                                    'data' => ['ASC'=>'ASC', 'DESC'=>'DESC'],
                                    'options' => ['placeholder' => 'No Sort'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>

                            <div class="col-md-3">
                                <?= $form->field($model, 'list_limit')->textInput() ?>
                            </div>



                        </div>
                    </div>

                    <div class="tab-pane fade" id="locate">
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'area_fieldname')->widget(Select2::classname(), [
                                    'name' => 'scope',
                                    'hideSearch' => true,
                                    'data' => $columns,
                                    'options' => ['placeholder' => 'ไม่มี...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-9">
                                <?= $form->field($model, 'area_visible')->checkboxList(s::getAreaScope()); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'time_fieldname')->widget(Select2::classname(), [
                                    'name' => 'time_fieldname',
                                    'hideSearch' => true,
                                    'data' => $columns,
                                    'options' => ['placeholder' => 'ไม่มี...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-9">
                                <?= $form->field($model, 'time_visible')->checkboxList(s::getTimeScope()); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'hosp_fieldname')->widget(Select2::classname(), [
                                    'name' => 'hosp_fieldname',
                                    'hideSearch' => true,
                                    'data' => $columns,
                                    'options' => ['placeholder' => 'ไม่มี...'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]); ?>
                            </div>
                            <div class="col-md-9">
                                <?= $form->field($model, 'hosp_visible')->checkboxList(s::getHostype()); ?>




                            </div>
                        </div>


                    </div>


                    <div class="tab-pane fade" id="grid">
                        <?= $form->field($model, 'column_header')->textarea(['rows' => 8]) ?>
                        <strong>Format:</strong> [caption]|[colspan]|[class]<br>
                        ตัวอย่าง:<br>
                        |2|<br>
                        รวม|3|text-center<br>
                       <br>
                        <?= $form->field($model, 'pagesize')->widget(Select2::classname(), [
                            'name' => 'pagesize',
                            'hideSearch' => true,
                            'data' => ['20'=>'20', '50'=>'50', '100'=>'100', '200'=>'200'],
                            'options' => ['placeholder' => 'No group'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>

                    <div class="tab-pane fade" id="template">
                        <?= $form->field($model, 'template')->widget(CKEditor::className(), [
                            'options' => ['rows' => 16],
                            'preset' => 'advance'
                        ]) ?>

                    </div>

                    <div class="tab-pane fade" id="permission">
                        <h3>Permission</h3>


                    </div>

                    <div class="tab-pane fade" id="note">
                        <?= $form->field($model, 'note')->widget(CKEditor::className(), [
                            'options' => ['rows' => 16],
                            'preset' => 'advance'
                        ]) ?>

                    </div>

                    <div class="tab-pane fade" id="chart">
                        <?= $form->field($model, 'chart_type')->widget(Select2::classname(), [
                            'name' => 'chart_type',
                            //'label'=>'Chart Type',
                            'hideSearch' => true,
                            'data' => ['0' => 'ไม่แสดง Chart', '1' => 'Line Chart', '2' => 'Bar Chart (Horizontal)', '6' => 'Bar Chart (Vertical)', '3' => 'Pie Chart', '4' => 'Area Chart', '5' => 'Stacked Bar'],
                            'options' => ['placeholder' => 'Not specific'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Chart Type'); ?>


                        <?= $form->field($model, 'chart_y')->widget(Select2::classname(), [
                            'name' => 'chart_y',
                            'hideSearch' => true,
                            'data' => array_merge(['(auto)'=>'(AUTO)'], $columns) ,
                            'options' => ['placeholder' => 'ไม่มี...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>



                            <?= $form->field($model, 'chart_x')->checkboxList($columns); ?>

                        <div class="row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'line1_caption')->textInput(['maxlength' => 255]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'line1_value')->textInput() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'line2_caption')->textInput(['maxlength' => 255]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'line2_value')->textInput() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'line3_caption')->textInput(['maxlength' => 255]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'line3_value')->textInput() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <?= $form->field($model, 'line4_caption')->textInput(['maxlength' => 255]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'line4_value')->textInput() ?>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <div class="col-md-4">
                <div class="panel panel-primary">

                    <div class="panel-body">

                        <?= $form->field($model, 'menutype')->widget(\kartik\tree\TreeViewInput::classname(),
                            [
                                'name' => 'category_list',
                                'value' => 'true', // preselected values
                                'query' => \common\models\ReportMenu::find()->where(['url' => null])->addOrderBy('root, lft'),
                                'headingOptions' => ['label' => 'ระบุ Parent Menu'],
                                'rootOptions' => ['label' => 'Menu'],
                                'fontAwesome' => true,
                                'asDropdown' => true,
                                'multiple' => true,
                                'options' => ['disabled' => false, 'height' => '1200px',]
                            ]); ?>

                    </div>
                </div>


            </div>
            <div class="col-md-4">
                <div class="panel panel-warning">

                    <div class="panel-body">
                        <?= $form->field($model, 'keyword')->widget(TagsinputWidget::classname(), [
                            'clientOptions' => [
                                'trimValue' => true,
                                'allowDuplicates' => false,
                                'value' => ['Amsterdam', 'Washington', 'Sydney', 'Beijing', 'Cairo'],
                                //'typeahead' => [
                                    'source' => ['Amsterdam', 'Washington', 'Sydney', 'Beijing', 'Cairo']
                                //]
                            ],
                            'options' => [
                                'typeahead' => [
                                    'source' => ['Amsterdam', 'Washington', 'Sydney', 'Beijing', 'Cairo']
                                ],

                            ]
                        ]) ?>


                        <?= $form->field($model, 'active')->checkbox() ?>





                    </div>
                </div>


            </div>

        </div>

    </div>


</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>


<div class="col-md-2" style="display:none;">
    <?php
    echo Select2::widget([
        'model' => $model,
        'attribute' => 'fields_param[fake][function]',
        'data' => [],
        'options' => ['label' => false, 'placeholder' => 'No function'],
        'hideSearch' => true,
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?php
    echo Select2::widget([
        'model' => $model,
        'attribute' => 'fields_param[fake][format]',
        'data' => [],
        'options' => ['label' => false, 'placeholder' => 'Not specific'],
        'hideSearch' => true,
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
</div>

