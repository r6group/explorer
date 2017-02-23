<?php
use kartik\tree\TreeView;
use common\models\ReportMenu;

$this->title = 'Menu Editor';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">Menu editor</h4>
    </div>
    <div class="panel-body">
        <?php
        echo TreeView::widget([
            // single query fetch to render the tree
            // use the Product model you have in the previous step
            'query' => ReportMenu::find()->addOrderBy('root, lft'),
            'headingOptions' => ['label' => 'Menu'],
            'fontAwesome' => false,     // optional
            'isAdmin' => Yii::$app->user->identity->getId() == 23,         // optional (toggle to enable admin mode)
            'displayValue' => 1,        // initial display value
            'softDelete' => true,       // defaults to true
            'cacheSettings' => [
                'enableCache' => true   // defaults to true
            ],
            'rootOptions' => [
                'label' => '<b>Menu</b>',
                'class' => 'text-primary'
            ],
            'iconEditSettings' => [
                'show' => 'list',
                'listData' => [
                    'folder' => 'Folder',
                    'file' => 'File',
                    'mobile' => 'Phone',
                    'bell' => 'Bell',
                ]
            ],
            'mainTemplate' => '
                <div class="row">
                    <div class="col-sm-4">
                        {wrapper}
                    </div>
                    <div class="col-sm-8">
                        {detail}
                    </div>
                </div>
            '
        ]);
        ?>
    </div>
</div>


