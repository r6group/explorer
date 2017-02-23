<?php

use kartik\sidenav\SideNav;
use yii\helpers\Url;
use frontend\modules\user\User;

$items = [
    [
        'label'  => 'Personal Area',
        'url'    => Url::toRoute(['index']),
        'active' => (Url::to('') == Url::to(['index'])),
        'icon' => 'list'
    ],
    [
        'label' => 'Profile',
        'url'   => Url::toRoute(['view']),
        'active' => (Url::to('') == Url::to(['view'])),
        'icon' => 'user'
    ],
    [
        'label' => 'Update profile',
        'url'   => Url::toRoute(['update']),
        'active' => (Url::to('') == Url::to(['update'])),
        'icon' => 'pencil'
    ],
    [
        'label' => 'Asset Manager',
        'url'   => Url::toRoute(['asset']),
        'active' => (Url::to('') == Url::to(['asset'])),
        'icon' => 'folder-close'
    ],
    [
        'label' => 'Payment history',
        'url'   => Url::toRoute(['history']),
        'active' => (Url::to('') == Url::to(['history'])),
        'icon' => 'usd'
    ],
];


echo SideNav::widget(
        [
            'heading' => 'Nav',
            'type' => SideNav::TYPE_PRIMARY,
            'items'   => $items,
            'activeCssClass' => 'active'
        ]
);