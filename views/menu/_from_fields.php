<?php
use kartik\select2\Select2;



$i = 0;
$js = '';
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
                <div class="form-group field-report-fields_param-<?= $value ?>-display">

                    <input type="hidden" name="Report[fields_param][<?= $value ?>][display]" value="0"><label><input
                            type="checkbox" id="report-fields_param-<?= $value ?>-display"
                            name="Report[fields_param][<?= $value ?>][display]" value="1" checked> แสดง</label>

                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group field-report-fields_param-<?= $value ?>-caption">

                    <input type="text" id="report-fields_param-<?= $value ?>-caption" class="form-control"
                           name="Report[fields_param][<?= $value ?>][caption]" maxlength="255">

                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group field-report-fields_param-<?= $value ?>-formula">

                    <input type="text" id="report-fields_param-<?= $value ?>-formula" class="form-control"
                           name="Report[fields_param][<?= $value ?>][formula]" maxlength="255">

                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-md-2">
                <?php
                echo Select2::widget([
                    'model' => $model,
                    'attribute' => 'fields_param[' . $value . '][function]',
                    'data' => ['' => 'NONE', 'count' => 'COUNT()', 'sum' => 'SUM()', 'avg' => 'AVG()', 'min' => 'MIN()', 'max' => 'MAX()', 'formula' => 'FORMULA()'],
                    'options' => ['label' => false, 'placeholder' => 'No function'],
                    'hideSearch' => true,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>


            <div class="col-md-2">
                <?php
                echo Select2::widget([
                    'model' => $model,
                    'attribute' => 'fields_param[' . $value . '][format]',
                    'data' => ['text' => 'ตัวอักษร', 'number' => 'จำนวนเต็ม', 'decimal' => 'เลขทศนิยม', 'date' => 'วันที่', 'html' => 'HTML'],
                    'options' => ['onchange' => '$("#report-fields_param-' . $value . '-format_val").prop("disabled", (this.value == "text" || this.value == "number" || this.value == ""))', 'label' => false, 'placeholder' => 'Not specific'],
                    'hideSearch' => true,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>


            <div class="col-md-1">
                <div class="form-group field-report-fields_param-<?= $value ?>-format_val">

                    <input type="text" id="report-fields_param-<?= $value ?>-format_val" class="form-control"
                           name="Report[fields_param][<?= $value ?>][format_val]" maxlength="255" disabled>

                    <div class="help-block"></div>
                </div>
            </div>
        </div>
    </div>


<?php } ?>


