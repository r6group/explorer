<?php

/* @var $this \yii\web\View */
/* @var $content string */


use common\widgets\Alert;
//use common\models\Profile;
//use common\models\Menu;
use phi\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);


?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="th-TH">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>


</head>
<body>


    <?= Alert::widget() ?>
    <?= $content ?>


<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>

