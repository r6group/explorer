<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use phi\assets\AppAsset;
use phi\widgets\Alert;
use app\models\Menu;
use app\models\MenuRawData;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php


        $items = [];
        $models = Menu::find()->all();
        foreach($models as $model) {
            $items[] = ['label' => $model->title, 'url' => ['/report/index', 'id'=>$model->id]];
        }
        if (Yii::$app->user->isGuest==false) {
            $items[] = '<li class="divider"></li>';
            $items[] = ['label' => 'จัดการเมนูรายงาน', 'url' => ['/menu/index']];
        }


        $items_raw = [];
        $models = MenuRawData::find()->all();
        foreach($models as $model) {
            $items_raw[] = ['label' => $model->title, 'url' => ['/report/raw', 'id'=>$model->id]];
        }
        if (Yii::$app->user->isGuest==false) {
            $items_raw[] = '<li class="divider"></li>';
            $items_raw[] = ['label' => 'จัดการเมนูรายงาน', 'url' => ['/menurawdata/index']];
        }

            NavBar::begin([
                'brandLabel' => 'Provincial Health Information',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'รายงาน',

                    'items'=>$items,


                ],
                ['label' => 'ข้อมูลสำหรับงานวิจัย',

                    'items'=>$items_raw,


                ],

                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],


            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->f_name . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; PHI Sakaeo <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
