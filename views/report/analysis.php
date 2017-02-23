<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 22/4/59
 * Time: 22:18
 */


$this->registerJs("
function AdjustIframeHeightOnLoad() { document.getElementById('form-iframe').style.height = document.getElementById('form-iframe').contentWindow.document.body.scrollHeight + 'px'; }
function AdjustIframeHeight(id, i) { document.getElementById('form-iframe'+id).style.height = parseInt(i) + 'px'; }

", yii\web\View::POS_END, 'my-options');
?>


<iframe id="form-iframe" src="http://zone6.cbo.moph.go.th/mis/analysis" style="margin:0; width:100%; height:100%; border:none; overflow:hidden;" scrolling="no" onload="AdjustIframeHeightOnLoad()"></iframe>