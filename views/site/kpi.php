<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Url::to('@web/js/frame_resizer/iframeResizer.min.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);

//$this->registerJsFile(Url::to('@web/js/frame_resizer/iframeResizer.contentWindow.min.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);

//$this->registerJs("
//
//    window.iFrameResizer = {
//        targetOrigin: 'http://zone6.sko.moph.go.th'
//    }
//
//
//", yii\web\View::POS_HEAD, 'iframe1');


$this->registerJs("

			iFrameResize({
				log                     : true,                  // Enable console logging
				inPageLinks             : true,
				  autoResize: true,

				resizedCallback         : function(messageData){ // Callback fn when resize is received
					$('p#callback').html(
						'<b>Frame ID:</b> '    + messageData.iframe.id +
						' <b>Height:</b> '     + messageData.height +
						' <b>Width:</b> '      + messageData.width +
						' <b>Event type:</b> ' + messageData.type
					);
				},
				messageCallback         : function(messageData){ // Callback fn when message is received
					$('p#callback').html(
						'<b>Frame ID:</b> '    + messageData.iframe.id +
						' <b>Message:</b> '    + messageData.message
					);
					alert(messageData.message);
					document.getElementsByTagName('iframe')[0].iFrameResizer.sendMessage('Hello back from parent page');
				},
				closedCallback         : function(id){ // Callback fn when iFrame is closed
					$('p#callback').html(
						'<b>IFrame (</b>'    + id +
						'<b>) removed from page.</b>'
					);
				}
			});

", yii\web\View::POS_END, 'iframe2');
?>


<iframe src="http://healthkpi.moph.go.th/kpi/index/?id=1&embeded=0&title=0&gis=0&gauge=0&chart=1&table=1&desc=0&comment=0&lv=2" width="100%" scrolling="no"></iframe>

<!-- MDN PolyFils for IE8 (This is not normally needed if you use the jQuery version) -->
<!--[if lte IE 8]>
    <?=$this->registerJsFile(Url::to('@web/js/frame_resizer/ie8.polyfils.min.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);?>
<![endif]-->

