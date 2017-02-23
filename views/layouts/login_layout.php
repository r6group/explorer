<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;

use yii\widgets\Breadcrumbs;
use phi\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\models\LoginForm;
use common\models\Profile;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!--<link rel="shortcut icon" href="<?= Url::to('@web/themes/quirk/images/favicon.png') ?>" type="image/png">-->
    <?= Yii::$app->view->registerJsFile(Url::to('@web/themes/quirk/lib/modernizr/modernizr.js'), ['position' => yii\web\View::POS_HEAD]); ?>



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?=Url::to('@web/themes/quirk/lib/html5shiv/html5shiv.js')?>"></script>
    <script src="<?=Url::to('@web/themes/quirk/lib/respond/respond.src.js')?>"></script>

    <style>

    <![endif]-->
</head>
<body class="signwrapper">

<?php $this->beginBody() ?>




<?= Alert::widget() ?>

<?= $content ?>



<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>
